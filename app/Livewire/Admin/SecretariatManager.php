<?php

namespace App\Livewire\Admin;

use App\Models\Secretariat;
use App\Services\LookupService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SecretariatManager extends Component
{
    use WithPagination, WithFileUploads;
    
    protected $paginationTheme = 'bootstrap';
    
    // Filter properties
    public $search = '';
    public $divisionFilter = 'all';
    public $statusFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $secretariatId = null;
    public $form = [];
    public $photo;
    public $currentPhoto = null;
    
    // Info modal properties
    public $showInfoModal = false;
    public $selectedSecretariat = null;
    
    // Bulk action properties
    public $selectedItems = [];
    public $selectAll = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'divisionFilter' => ['as' => 'division', 'except' => 'all'],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingDivisionFilter()
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
        $this->selectedSecretariat = Secretariat::find($id);
        if ($this->selectedSecretariat) {
            $this->showInfoModal = true;
        }
    }
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->form['is_active'] = true;
        $this->showModal = true;
    }
    
    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->secretariatId = $id;
        
        $secretariat = Secretariat::find($id);
        if ($secretariat) {
            $this->form = [
                'name' => $secretariat->name,
                'nip' => $secretariat->nip,
                'position' => $secretariat->position,
                'division' => $secretariat->division,
                'contact' => $secretariat->contact,
                'address' => $secretariat->address,
                'description' => $secretariat->description,
                'is_active' => $secretariat->is_active,
            ];
            $this->currentPhoto = $secretariat->photo;
        }
        
        $this->showModal = true;
    }
    
    public function save()
    {
        $this->validate($this->getRules());
        
        try {
            $data = [
                'name' => $this->form['name'],
                'nip' => $this->form['nip'] ?? null,
                'position' => $this->form['position'] ?? null,
                'division' => $this->form['division'] ?? null,
                'contact' => $this->form['contact'] ?? null,
                'address' => $this->form['address'] ?? null,
                'description' => $this->form['description'] ?? null,
                'is_active' => $this->form['is_active'] ?? true,
            ];
            
            // Handle photo upload
            if ($this->photo) {
                // Delete old photo if exists
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                
                $data['photo'] = $this->photo->store('secretariat', 'public');
            }
            
            if ($this->editMode) {
                $secretariat = Secretariat::find($this->secretariatId);
                $data['updated_by'] = auth()->id();
                $secretariat->update($data);
                $message = 'Data sekretariat berhasil diupdate';
            } else {
                $data['created_by'] = auth()->id();
                Secretariat::create($data);
                $message = 'Data sekretariat berhasil ditambahkan';
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
            $secretariat = Secretariat::find($id);
            
            if ($secretariat->photo) {
                Storage::disk('public')->delete($secretariat->photo);
            }
            
            $secretariat->delete();
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Data sekretariat berhasil dihapus'
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
            $secretariat = Secretariat::find($id);
            $secretariat->is_active = !$secretariat->is_active;
            $secretariat->updated_by = auth()->id();
            $secretariat->save();
            
            $statusText = $secretariat->is_active ? 'diaktifkan' : 'dinonaktifkan';
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Data sekretariat berhasil {$statusText}"
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
            $this->selectedItems = Secretariat::pluck('id')->toArray();
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
            $secretariats = Secretariat::whereIn('id', $this->selectedItems)->get();
            
            foreach ($secretariats as $secretariat) {
                if ($secretariat->photo) {
                    Storage::disk('public')->delete($secretariat->photo);
                }
                $secretariat->delete();
            }
            
            $count = count($this->selectedItems);
            $this->selectedItems = [];
            $this->selectAll = false;
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "{$count} data sekretariat berhasil dihapus"
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
            Secretariat::whereIn('id', $this->selectedItems)->update([
                'is_active' => $status,
                'updated_by' => auth()->id()
            ]);
            
            $count = count($this->selectedItems);
            $this->selectedItems = [];
            $this->selectAll = false;
            
            $statusText = $status ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "{$count} data sekretariat berhasil {$statusText}"
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
        $this->photo = null;
        $this->currentPhoto = null;
        $this->secretariatId = null;
        $this->editMode = false;
    }
    
    public function getRules()
    {
        return [
            'form.name' => 'required|string|max:100',
            'form.nip' => 'nullable|string|max:30',
            'form.position' => 'nullable|string|max:100',
            'form.division' => 'nullable|string|max:100',
            'form.contact' => 'nullable|string|max:100',
            'form.address' => 'nullable|string|max:255',
            'form.description' => 'nullable|string',
            'form.is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048',
        ];
    }
    
    public function render()
    {
        $secretariats = Secretariat::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nip', 'like', '%' . $this->search . '%')
                      ->orWhere('position', 'like', '%' . $this->search . '%')
                      ->orWhere('contact', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->divisionFilter !== 'all', function ($query) {
                $query->where('division', $this->divisionFilter);
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $status = $this->statusFilter === 'active' ? 1 : 0;
                $query->where('is_active', $status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
        
        // Get lookup data
        $lookupService = app(LookupService::class);
        $divisions = $lookupService->getCollection('division')->sortBy('data1');
        $positions = $lookupService->getCollection('position')->sortBy('data1');
        
        return view('livewire.admin.secretariat-manager', [
            'secretariats' => $secretariats,
            'divisions' => $divisions,
            'positions' => $positions,
        ]);
    }
}
