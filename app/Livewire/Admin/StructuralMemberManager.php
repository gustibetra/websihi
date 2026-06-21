<?php

namespace App\Livewire\Admin;

use App\Models\StructuralMember;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StructuralMemberManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Filter properties
    public $search = '';
    public $statusFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    // Bulk Action Properties
    public $selectedItems = [];
    public $selectAll = false;

    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $memberId = null;
    public $form = [];
    public $photo;
    public $currentPhoto = null;

    // Info modal properties
    public $showInfoModal = false;
    public $selectedMember = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
    ];

    public function mount()
    {
        if (auth()->user()->isAdminJurusan()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function updatingSearch()
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
        $this->selectedMember = StructuralMember::find($id);
        if ($this->selectedMember) {
            $this->showInfoModal = true;
        }
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;

        $this->form = [
            'name' => '',
            'gender' => 'male',
            'birth_place' => '',
            'birth_date' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'jabatan' => '',
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
        $this->memberId = $id;

        $member = StructuralMember::find($id);
        if ($member) {
            $this->form = [
                'name' => $member->name,
                'gender' => $member->gender,
                'birth_place' => $member->birth_place,
                'birth_date' => $member->birth_date?->format('Y-m-d'),
                'address' => $member->address,
                'phone' => $member->phone,
                'email' => $member->email,
                'jabatan' => $member->jabatan,
                'description' => $member->description,
                'is_active' => $member->is_active,
                'photo_cropped' => null,
            ];
            $this->currentPhoto = $member->photo;
        }

        $this->showModal = true;
        $this->dispatch('open-modal');
    }

    public function save()
    {
        $this->validate($this->getRules(), [
            'photo.required_without' => 'Foto wajib diunggah untuk data baru.',
        ]);

        try {
            $data = [
                'name' => $this->form['name'],
                'gender' => $this->form['gender'],
                'birth_place' => $this->form['birth_place'] ?? null,
                'birth_date' => $this->form['birth_date'] ?: null,
                'address' => $this->form['address'] ?? null,
                'phone' => $this->form['phone'] ?? null,
                'email' => $this->form['email'] ?? null,
                'jabatan' => $this->form['jabatan'],
                'description' => $this->form['description'] ?? null,
                'is_active' => $this->form['is_active'] ?? false,
            ];

            // Handle photo upload dengan cropper.js
            if (!empty($this->form['photo_cropped'])) {
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $imageData = $this->form['photo_cropped'];
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
                $imageData = base64_decode($imageData);
                $filename = 'structural/' . uniqid('structural_', true) . '.jpg';
                Storage::disk('public')->put($filename, $imageData);
                $data['photo'] = $filename;
            } elseif ($this->photo) {
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $photoPath = $this->photo->store('structural', 'public');
                $data['photo'] = $photoPath;
            }

            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                $member = StructuralMember::find($this->memberId);
                $member->update($data);
                $message = 'Data Struktural Yayasan berhasil diupdate';
            } else {
                $data['created_by'] = auth()->id();
                StructuralMember::create($data);
                $message = 'Data Struktural Yayasan berhasil ditambahkan';
            }

            $this->showModal = false;
            $this->resetForm();
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => $message
            ]);
            $this->dispatch('close-modal');
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
            $member = StructuralMember::find($id);
            if (!$member) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }

            $member->delete();

            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Data Struktural Yayasan berhasil dihapus']);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $member = StructuralMember::find($id);
            if (!$member) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            $member->update(['is_active' => !$member->is_active]);
            $statusText = $member->is_active ? 'diaktifkan' : 'dinonaktifkan';

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Data Struktural Yayasan berhasil {$statusText}"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Bulk Actions
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedItems = StructuralMember::query()
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('jabatan', 'like', '%' . $this->search . '%');
                    });
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
            $members = StructuralMember::whereIn('id', $this->selectedItems)->get();

            foreach ($members as $member) {
                if ($member->photo) {
                    Storage::disk('public')->delete($member->photo);
                }
                $member->delete();
            }

            $count = count($this->selectedItems);
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
            StructuralMember::whereIn('id', $this->selectedItems)->update([
                'is_active' => $status,
                'updated_by' => auth()->id()
            ]);

            $count = count($this->selectedItems);
            $this->selectedItems = [];
            $this->selectAll = false;

            $statusText = $status ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "{$count} data berhasil {$statusText}"
            ]);

            $this->dispatch('bulk-action-completed');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    private function resetForm()
    {
        $this->form = [];
        $this->memberId = null;
        $this->photo = null;
        $this->currentPhoto = null;
        $this->resetValidation();
    }

    public function getRules()
    {
        $rules = [
            'form.name' => 'required|string|max:100',
            'form.gender' => 'required|in:male,female',
            'form.birth_place' => 'nullable|string|max:100',
            'form.birth_date' => 'nullable|date',
            'form.address' => 'nullable|string|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.email' => 'nullable|email|max:100',
            'form.jabatan' => 'required|string|max:100',
            'form.is_active' => 'boolean',
            'form.description' => 'nullable|string',
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
        $members = StructuralMember::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('jabatan', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $status = $this->statusFilter === 'active' ? 1 : 0;
                $query->where('is_active', $status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.structural-member-manager', [
            'members' => $members,
            'jabatans' => \App\Models\Common::getByTable('jabatan_organisasi')
        ]);
    }
}
