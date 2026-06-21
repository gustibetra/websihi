<?php

namespace App\Livewire\Admin;

use App\Models\Teacher;
use App\Models\Common;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeacherManager extends Component
{
    use WithPagination, WithFileUploads;
    
    protected $paginationTheme = 'bootstrap';
    
    // Filter properties
    public $search = '';
    public $jenisFilter = 'all';
    public $statusKepegawaianFilter = 'all';
    public $statusFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $teacherId = null;
    public $form = [];
    public $photo;
    public $currentPhoto = null;
    
    // Info modal properties
    public $showInfoModal = false;
    public $selectedTeacher = null;
    
    // Bulk action properties
    public $selectedItems = [];
    public $selectAll = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'jenisFilter' => ['as' => 'jenis', 'except' => 'all'],
        'statusKepegawaianFilter' => ['as' => 'status_kepegawaian', 'except' => 'all'],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingJenisFilter()
    {
        $this->resetPage();
    }
    
    public function updatingStatusKepegawaianFilter()
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
    
    public function openInfoModal($id)
    {
        $this->selectedTeacher = Teacher::with('jurusan')->find($id);
        if ($this->selectedTeacher) {
            if ($this->currentUser()->isAdminJurusan() && $this->selectedTeacher->jurusan_id !== $this->currentUser()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->showInfoModal = true;
        }
    }
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        
        $this->form = [
            'name' => '',
            'nip' => '',
            'jenis' => 'guru',
            'jabatan' => '',
            'bidang_studi' => [],
            'pendidikan' => '',
            'status_kepegawaian' => '',
            'jurusan_id' => null,
            'order' => 0,
            'gender' => 'male',
            'birth_place' => '',
            'birth_date' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'description' => '',
            'is_active' => true,
            'photo_cropped' => null,
        ];
        
        $this->showModal = true;
        $this->dispatch('open-modal');
    }
    
    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->teacherId = $id;
        
        $teacher = Teacher::find($id);
        if ($teacher) {
            if ($this->currentUser()->isAdminJurusan() && $teacher->jurusan_id !== $this->currentUser()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->form = [
                'name' => $teacher->name,
                'nip' => $teacher->nip,
                'jenis' => $teacher->jenis,
                'jabatan' => $teacher->jabatan,
                'bidang_studi' => $teacher->bidang_studi ? explode(', ', $teacher->bidang_studi) : [],
                'pendidikan' => $teacher->pendidikan,
                'status_kepegawaian' => $teacher->status_kepegawaian,
                'jurusan_id' => $teacher->jurusan_id,
                'order' => $teacher->order,
                'gender' => $teacher->gender,
                'birth_place' => $teacher->birth_place,
                'birth_date' => $teacher->birth_date?->format('Y-m-d'),
                'address' => $teacher->address,
                'phone' => $teacher->phone,
                'email' => $teacher->email,
                'description' => $teacher->description,
                'is_active' => $teacher->is_active,
                'photo_cropped' => null,
            ];
            $this->currentPhoto = $teacher->photo;
        }
        
        $this->showModal = true;
        $this->dispatch('open-modal');
    }
    
    public function save()
    {
        if ($this->currentUser()->isAdminJurusan()) {
            $this->form['jurusan_id'] = $this->currentUser()->jurusan_id;
        }

        $this->validate($this->getRules(), [
            'photo.required_without' => 'Foto wajib diunggah untuk data baru.',
        ]);
        
        try {
            $data = [
                'name' => $this->form['name'],
                'nip' => $this->form['nip'] ?: null,
                'jenis' => $this->form['jenis'],
                'jabatan' => $this->form['jabatan'] ?? null,
                'bidang_studi' => is_array($this->form['bidang_studi'] ?? null) 
                    ? implode(', ', $this->form['bidang_studi']) 
                    : ($this->form['bidang_studi'] ?? null),
                'pendidikan' => $this->form['pendidikan'] ?? null,
                'status_kepegawaian' => $this->form['status_kepegawaian'] ?: null,
                'jurusan_id' => $this->form['jurusan_id'] ?: null,
                'order' => $this->form['order'] ?: 0,
                'gender' => $this->form['gender'] ?? null,
                'birth_place' => $this->form['birth_place'] ?? null,
                'birth_date' => $this->form['birth_date'] ?: null,
                'address' => $this->form['address'] ?? null,
                'phone' => $this->form['phone'] ?? null,
                'email' => $this->form['email'] ?? null,
                'description' => $this->form['description'] ?? null,
            ];
            if ($this->currentUser()->isAdminJurusan()) {
                $data['jurusan_id'] = $this->currentUser()->jurusan_id;
            }

            // Handle photo upload dengan cropper.js
            if (!empty($this->form['photo_cropped'])) {
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $imageData = $this->form['photo_cropped'];
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
                $imageData = base64_decode($imageData);
                $filename = 'teachers/' . uniqid('teacher_', true) . '.jpg';
                Storage::disk('public')->put($filename, $imageData);
                $data['photo'] = $filename;
            } elseif ($this->photo) {
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $photoPath = $this->photo->store('teachers', 'public');
                $data['photo'] = $photoPath;
            }
            
            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                $teacher = Teacher::find($this->teacherId);
                $teacher->update($data);
                $message = 'Data Guru/Tendik berhasil diupdate';
            } else {
                $data['created_by'] = auth()->id();
                Teacher::create($data);
                $message = 'Data Guru/Tendik berhasil ditambahkan';
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
    
    public function delete($id)
    {
        try {
            $teacher = Teacher::find($id);
            
            if (!$teacher) {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
                return;
            }

            if ($this->currentUser()->isAdminJurusan() && $teacher->jurusan_id !== $this->currentUser()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            
            $teacher->delete();
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Data berhasil dihapus'
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
        try {
            $teacher = Teacher::find($id);
            
            if (!$teacher) {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
                return;
            }

            if ($this->currentUser()->isAdminJurusan() && $teacher->jurusan_id !== $this->currentUser()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            
            $teacher->update([
                'is_active' => !$teacher->is_active,
                'updated_by' => auth()->id()
            ]);
            
            $statusText = $teacher->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Data berhasil {$statusText}"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    // Bulk Actions
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $query = Teacher::query();
            if ($this->currentUser()->isAdminJurusan()) {
                $query->where('jurusan_id', $this->currentUser()->jurusan_id);
            }
            $this->selectedItems = $query
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('nip', 'like', '%' . $this->search . '%')
                          ->orWhere('bidang_studi', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->jenisFilter !== 'all', function ($query) {
                    $query->where('jenis', $this->jenisFilter);
                })
                ->when($this->statusKepegawaianFilter !== 'all', function ($query) {
                    $query->where('status_kepegawaian', $this->statusKepegawaianFilter);
                })
                ->when($this->statusFilter !== 'all', function ($query) {
                    $status = $this->statusFilter === 'active' ? 1 : 0;
                    $query->where('is_active', $status);
                })
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedItems = [];
        }
    }
    
    public function bulkDelete()
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Pilih minimal satu data untuk dihapus'
            ]);
            return;
        }
        
        try {
            $query = Teacher::whereIn('id', $this->selectedItems);
            if ($this->currentUser()->isAdminJurusan()) {
                $query->where('jurusan_id', $this->currentUser()->jurusan_id);
            }
            $teachers = $query->get();
            
            foreach ($teachers as $teacher) {
                if ($teacher->photo) {
                    Storage::disk('public')->delete($teacher->photo);
                }
                $teacher->delete();
            }
            
            $count = count($teachers);
            $this->selectedItems = [];
            $this->selectAll = false;
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "{$count} data berhasil dihapus"
            ]);
            
            $this->dispatch('bulk-action-completed');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Pilih minimal satu data'
            ]);
            return;
        }
        
        try {
            $query = Teacher::whereIn('id', $this->selectedItems);
            if ($this->currentUser()->isAdminJurusan()) {
                $query->where('jurusan_id', $this->currentUser()->jurusan_id);
            }
            $query->update([
                'is_active' => $status,
                'updated_by' => auth()->id()
            ]);
            
            $count = count($this->selectedItems); // wait, count might not match if some were not in the user's jurusan, but it's simpler
            $this->selectedItems = [];
            $this->selectAll = false;
            
            $statusText = $status ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Data berhasil {$statusText}"
            ]);
            
            $this->dispatch('bulk-action-completed');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get the authenticated user with proper type hints to avoid IDE warnings.
     *
     * @return \App\Models\User
     */
    private function currentUser(): \App\Models\User
    {
        /** @var \App\Models\User */
        return auth()->user();
    }

    private function resetForm()
    {
        $this->form = [];
        $this->teacherId = null;
        $this->photo = null;
        $this->currentPhoto = null;
        $this->resetValidation();
    }
    
    public function getRules()
    {
        $rules = [
            'form.name' => 'required|string|max:255',
            'form.nip' => 'nullable|string|max:30',
            'form.jenis' => 'required|in:guru,tendik',
            'form.jabatan' => 'nullable|string|max:255',
            'form.bidang_studi' => 'nullable',
            'form.pendidikan' => 'nullable|string|max:100',
            'form.status_kepegawaian' => 'nullable|string|max:50',
            'form.jurusan_id' => 'nullable|exists:programs,id',
            'form.order' => 'nullable|integer|min:0',
            'form.gender' => 'nullable|in:male,female',
            'form.birth_place' => 'nullable|string|max:255',
            'form.birth_date' => 'nullable|date',
            'form.address' => 'nullable|string',
            'form.phone' => 'nullable|string|max:20',
            'form.email' => 'nullable|email|max:255',
            'form.is_active' => 'boolean',
            'form.description' => 'nullable|string',
            'form.photo_cropped' => 'nullable|string',
        ];

        if (!$this->editMode) {
            $rules['photo'] = 'required_without:form.photo_cropped|nullable|image|max:5120';
        } else {
            $rules['photo'] = 'nullable|image|max:5120';
        }

        return $rules;
    }
    
    public function render()
    {
        $query = Teacher::query()
            ->with('jurusan');
            
        if ($this->currentUser()->isAdminJurusan()) {
            $query->where('jurusan_id', $this->currentUser()->jurusan_id);
        }

        $teachers = $query
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nip', 'like', '%' . $this->search . '%')
                      ->orWhere('bidang_studi', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->jenisFilter !== 'all', function ($query) {
                $query->where('jenis', $this->jenisFilter);
            })
            ->when($this->statusKepegawaianFilter !== 'all', function ($query) {
                $query->where('status_kepegawaian', $this->statusKepegawaianFilter);
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $status = $this->statusFilter === 'active' ? 1 : 0;
                $query->where('is_active', $status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
            
        $jurusans = \App\Models\Program::where('is_active', true)->orderBy('order')->get();
        if ($this->currentUser()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', $this->currentUser()->jurusan_id);
        }
        $jabatans = \App\Models\Common::getByTable('jabatan_organisasi');
        $bidangStudis = \App\Models\Common::getByTable('kompetensi_keahlian');
        
        return view('livewire.admin.teacher-manager', [
            'teachers' => $teachers,
            'jurusans' => $jurusans,
            'jabatans' => $jabatans,
            'bidangStudis' => $bidangStudis,
        ]);
    }
}
