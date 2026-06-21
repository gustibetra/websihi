<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserManager extends Component
{
    use WithPagination, WithFileUploads;
    
    protected $paginationTheme = 'bootstrap';
    
    // Filter properties
    public $search = '';
    public $roleFilter = 'all';
    public $statusFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    // Form properties
    public $showModal = false;
    public $showPasswordModal = false;
    public $editMode = false;
    public $userId = null;
    public $form = [];
    public $photo;
    public $currentPhoto = null;
    public $editedUserRole = null; // role asli user yg sedang diedit
    
    // Password change properties
    public $passwordForm = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['as' => 'role', 'except' => 'all'],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingRoleFilter()
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    
    public function sortByColumn($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->form['is_active'] = true; // Default active
        $this->form['jurusan_id'] = null;
        $this->showModal = true;
        $this->dispatch('open-modal');
    }
    
    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->userId = $id;
        
        $user = User::find($id);
        if ($user) {
            $this->form = [
                'username'   => $user->username,
                'name'       => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone,
                'role'       => $user->role,
                'jurusan_id' => $user->jurusan_id,
                'is_active'  => $user->is_active,
            ];
            $this->currentPhoto  = $user->photo;
            $this->editedUserRole = $user->role; // simpan role asli
        }
        
        $this->showModal = true;
        $this->dispatch('open-modal');
    }
    
    public function openPasswordModal($id)
    {
        $this->userId = $id;
        $this->passwordForm = [];
        $this->showPasswordModal = true;
        $this->dispatch('open-password-modal');
    }
    
    public function save()
    {
        $this->validate($this->getRules());
        
        try {
            $data = [
                'username'   => $this->form['username'],
                'name'       => $this->form['name'],
                'email'      => $this->form['email'] ?? null,
                'phone'      => $this->form['phone'] ?? null,
                'is_active'  => $this->form['is_active'] ?? false,
            ];

            // SuperAdmin tidak bisa diubah rolenya melalui form
            if ($this->editMode && $this->editedUserRole === 'SuperAdmin') {
                $data['role'] = 'SuperAdmin'; // lock role
                $data['jurusan_id'] = null;
            } else {
                $data['role'] = $this->form['role'];
                $data['jurusan_id'] = ($this->form['role'] === 'Admin') ? ($this->form['jurusan_id'] ?: null) : null;
            }
            
            // Handle password for create
            if (!$this->editMode && !empty($this->form['password'])) {
                $data['password'] = Hash::make($this->form['password']);
            }
            
            // Handle photo upload — menerima base64 dari cropper.js
            if (!empty($this->form['photo_cropped'])) {
                // Hapus foto lama jika ada
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                // Decode base64 dan simpan
                $imageData = $this->form['photo_cropped'];
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
                $imageData = base64_decode($imageData);
                $filename = 'users/' . uniqid('avatar_', true) . '.jpg';
                Storage::disk('public')->put($filename, $imageData);
                $data['photo'] = $filename;
            } elseif ($this->photo) {
                // Fallback: upload langsung jika cropper tidak digunakan
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $photoPath = $this->photo->store('users', 'public');
                $data['photo'] = $photoPath;
            }
            
            if ($this->editMode) {
                $user = User::find($this->userId);
                
                // Prevent deactivating self
                if ($user->id === auth()->id() && !$data['is_active']) {
                    $this->dispatch('show-toast', [
                        'type' => 'error',
                        'message' => 'Tidak dapat menonaktifkan user yang sedang login'
                    ]);
                    return;
                }
                
                $user->update($data);
                $message = 'User berhasil diupdate';
            } else {
                User::create($data);
                $message = 'User berhasil dibuat';
            }
            
            $this->showModal = false;
            $this->resetForm();
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => $message
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    public function changePassword()
    {
        $this->validate([
            'passwordForm.new_password' => 'required|string|min:6|confirmed',
            'passwordForm.new_password_confirmation' => 'required',
        ], [
            'passwordForm.new_password.required' => 'Password baru wajib diisi',
            'passwordForm.new_password.min' => 'Password minimal 6 karakter',
            'passwordForm.new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);
        
        try {
            $user = User::find($this->userId);
            
            if (!$user) {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => 'User tidak ditemukan'
                ]);
                return;
            }
            
            $user->update([
                'password' => Hash::make($this->passwordForm['new_password'])
            ]);
            
            $this->showPasswordModal = false;
            $this->passwordForm = [];
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Password berhasil diubah'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete($id)
    {
        // Prevent self-deletion
        if ($id == auth()->id()) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Tidak dapat menghapus user yang sedang login'
            ]);
            return;
        }
        
        try {
            $user = User::find($id);
            
            if (!$user) {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => 'User tidak ditemukan'
                ]);
                return;
            }
            
            // Delete photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            
            $user->delete();
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    public function toggleStatus($id)
    {
        // Prevent deactivating self
        if ($id == auth()->id()) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Tidak dapat mengubah status user yang sedang login'
            ]);
            return;
        }
        
        try {
            $user = User::find($id);
            
            if (!$user) {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => 'User tidak ditemukan'
                ]);
                return;
            }
            
            $user->update(['is_active' => !$user->is_active]);
            
            $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "User berhasil {$statusText}"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    private function resetForm()
    {
        $this->form = [
            'username'   => '',
            'name'       => '',
            'email'      => '',
            'phone'      => '',
            'role'       => '',
            'jurusan_id' => null,
            'is_active'  => true,
        ];
        $this->userId = null;
        $this->photo = null;
        $this->currentPhoto = null;
        $this->editedUserRole = null;
        $this->resetValidation();
    }
    
    public function getRules()
    {
        // Jika edit SuperAdmin, role tidak perlu divalidasi dari form
        $roleRule = ($this->editMode && $this->editedUserRole === 'SuperAdmin')
            ? 'nullable|string'
            : 'required|in:SuperAdmin,Admin,Operator';

        $rules = [
            'form.username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                $this->editMode 
                    ? Rule::unique('users', 'username')->ignore($this->userId)
                    : 'unique:users,username'
            ],
            'form.name'      => 'required|string|max:100',
            'form.email'     => [
                'nullable',
                'email',
                'max:100',
                $this->editMode 
                    ? Rule::unique('users', 'email')->ignore($this->userId)
                    : 'unique:users,email'
            ],
            'form.phone'      => 'nullable|string|max:20',
            'form.role'       => $roleRule,
            'form.jurusan_id' => 'required_if:form.role,Admin|nullable|exists:programs,id',
            'form.is_active'  => 'boolean',
            'photo'           => 'nullable|image|max:5120', // 5MB max untuk di-crop
        ];
        
        // Password required only for create
        if (!$this->editMode) {
            $rules['form.password'] = 'required|string|min:6|confirmed';
            $rules['form.password_confirmation'] = 'required';
        }
        
        return $rules;
    }
    
    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('username', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter !== 'all', function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $status = $this->statusFilter === 'active' ? 1 : 0;
                $query->where('is_active', $status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
        
        return view('livewire.admin.user-manager', [
            'users'           => $users,
            'editedUserRole'  => $this->editedUserRole,
            'jurusans'        => \App\Models\Program::where('is_active', true)->orderBy('nama')->get(),
        ]);
    }
}
