<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Services\LookupService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AgendaManager extends Component
{
    use WithPagination, WithFileUploads;
    
    protected $paginationTheme = 'bootstrap';
    
    // Filter properties
    public $search = '';
    public $categoryFilter = 'all';
    public $jurusanFilter = 'all';
    public $periodFilter = 'all';
    public $statusFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'start_datetime';
    public $sortDirection = 'desc';
    
    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $agendaId = null;
    public $form = [];
    public $image;
    public $banner;
    public $attachment;
    public $currentImage = null;
    public $currentBanner = null;
    public $currentAttachment = null;
    
    // Info modal properties
    public $showInfoModal = false;
    public $selectedAgenda = null;
    
    // Bulk action properties
    public $selectedItems = [];
    public $selectAll = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['as' => 'category', 'except' => 'all'],
        'jurusanFilter' => ['as' => 'jurusan', 'except' => 'all'],
        'periodFilter' => ['as' => 'period', 'except' => 'all'],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
    ];

    public function mount()
    {
        if (auth()->user()->isAdminJurusan()) {
            $this->jurusanFilter = auth()->user()->jurusan_id;
        }
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingPeriodFilter()
    {
        $this->resetPage();
    }
    
    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }
    
    public function updatingJurusanFilter()
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
        $this->selectedAgenda = Event::with(['category', 'jurusan'])->find($id);
        if ($this->selectedAgenda) {
            if (auth()->user()->isAdminJurusan() && $this->selectedAgenda->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->showInfoModal = true;
        }
    }
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->form['is_active'] = true;
        $this->form['is_public'] = true;
        $this->showModal = true;
        $this->dispatch('modal-opened');
    }
    
    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->agendaId = $id;
        
        $agenda = Event::find($id);
        if ($agenda) {
            if (auth()->user()->isAdminJurusan() && $agenda->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->form = [
                'title' => $agenda->title,
                'slug' => $agenda->slug,
                'description' => $agenda->description,
                'excerpt' => $agenda->excerpt,
                'location' => $agenda->location,
                'start_datetime' => $agenda->start_datetime?->format('Y-m-d\TH:i'),
                'end_datetime' => $agenda->end_datetime?->format('Y-m-d\TH:i'),
                'speaker' => $agenda->speaker,
                'organizer' => $agenda->organizer,
                'category_id' => $agenda->category_id,
                'jurusan_id' => $agenda->jurusan_id,
                'period' => $agenda->period,
                'is_active' => $agenda->is_active,
                'is_public' => $agenda->is_public,
            ];
            $this->currentImage = $agenda->image;
            $this->currentBanner = $agenda->banner;
            $this->currentAttachment = $agenda->attachment;
            $this->showModal = true;
            $this->dispatch('modal-opened');
        }
    }
    
    public function updatedFormTitle($value)
    {
        if (!$this->editMode) {
            $this->form['slug'] = Str::slug($value);
        }
    }
    
    public function save()
    {
        $rules = [
            'form.title' => 'required|max:255',
            'form.slug' => 'required|max:150|unique:events,slug,' . ($this->agendaId ?? 'NULL'),
            'form.category_id' => 'nullable',
            'form.jurusan_id' => 'nullable|integer|exists:programs,id',
            'form.start_datetime' => 'nullable|date',
            'form.end_datetime' => 'nullable|date|after_or_equal:form.start_datetime',
            'image' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
            'attachment' => 'nullable|file|max:5120',
        ];
        
        if (auth()->user()->isAdminJurusan()) {
            $this->form['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $this->validate($rules);
        
        try {
            $data = $this->form;
            
            // Clean up nullable relationships
            if (isset($data['category_id']) && $data['category_id'] === '') {
                $data['category_id'] = null;
            }
            if (isset($data['jurusan_id']) && $data['jurusan_id'] === '') {
                $data['jurusan_id'] = null;
            }
            
            // Handle image upload
            if ($this->image) {
                if ($this->editMode && $this->currentImage) {
                    Storage::delete('public/' . $this->currentImage);
                }
                $data['image'] = $this->image->store('agendas/images', 'public');
            }
            
            // Handle banner upload
            if ($this->banner) {
                if ($this->editMode && $this->currentBanner) {
                    Storage::delete('public/' . $this->currentBanner);
                }
                $data['banner'] = $this->banner->store('agendas/banners', 'public');
            }
            
            // Handle attachment upload
            if ($this->attachment) {
                if ($this->editMode && $this->currentAttachment) {
                    Storage::delete('public/' . $this->currentAttachment);
                }
                // Store with original filename
                $originalName = $this->attachment->getClientOriginalName();
                $data['attachment'] = $this->attachment->storeAs('agendas/attachments', $originalName, 'public');
            }
            
            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                Event::find($this->agendaId)->update($data);
                session()->flash('message', 'Agenda berhasil diperbarui.');
            } else {
                $data['created_by'] = auth()->id();
                Event::create($data);
                session()->flash('message', 'Agenda berhasil ditambahkan.');
            }
            
            $this->showModal = false;
            $this->resetForm();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function toggleStatus($id)
    {
        $agenda = Event::find($id);
        if ($agenda) {
            if (auth()->user()->isAdminJurusan() && $agenda->jurusan_id !== auth()->user()->jurusan_id) {
                return;
            }
            $agenda->update(['is_active' => !$agenda->is_active]);
            session()->flash('message', 'Status agenda berhasil diperbarui.');
        }
    }
    
    public function delete($id)
    {
        $agenda = Event::find($id);
        if ($agenda) {
            if (auth()->user()->isAdminJurusan() && $agenda->jurusan_id !== auth()->user()->jurusan_id) {
                return;
            }
            // Delete files
            if ($agenda->image && Storage::exists('public/' . $agenda->image)) {
                Storage::delete('public/' . $agenda->image);
            }
            if ($agenda->banner && Storage::exists('public/' . $agenda->banner)) {
                Storage::delete('public/' . $agenda->banner);
            }
            if ($agenda->attachment && Storage::exists('public/' . $agenda->attachment)) {
                Storage::delete('public/' . $agenda->attachment);
            }
            
            $agenda->delete();
            session()->flash('message', 'Agenda berhasil dihapus.');
        }
    }
    
    // Bulk actions
    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih setidaknya satu agenda.');
            return;
        }
        
        $query = Event::whereIn('id', $this->selectedItems);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }
        $query->update(['is_active' => $status]);
        $this->selectedItems = [];
        $this->selectAll = false;
        session()->flash('message', 'Status agenda berhasil diperbarui.');
    }
    
    public function bulkDelete()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih setidaknya satu agenda.');
            return;
        }
        
        $query = Event::whereIn('id', $this->selectedItems);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }
        $agendas = $query->get();
        
        foreach ($agendas as $agenda) {
            // Delete files
            if ($agenda->image && Storage::exists('public/' . $agenda->image)) {
                Storage::delete('public/' . $agenda->image);
            }
            if ($agenda->banner && Storage::exists('public/' . $agenda->banner)) {
                Storage::delete('public/' . $agenda->banner);
            }
            if ($agenda->attachment && Storage::exists('public/' . $agenda->attachment)) {
                Storage::delete('public/' . $agenda->attachment);
            }
            $agenda->delete();
        }
        
        $this->selectedItems = [];
        $this->selectAll = false;
        session()->flash('message', count($agendas) . ' agenda berhasil dihapus.');
    }
    
    protected function resetForm()
    {
        $this->form = [
            'title' => '',
            'slug' => '',
            'description' => '',
            'excerpt' => '',
            'location' => '',
            'start_datetime' => '',
            'end_datetime' => '',
            'speaker' => '',
            'organizer' => '',
            'category_id' => '',
            'jurusan_id' => '',
            'period' => '',
            'is_active' => true,
            'is_public' => true,
        ];
        $this->image = null;
        $this->banner = null;
        $this->attachment = null;
        $this->currentImage = null;
        $this->currentBanner = null;
        $this->currentAttachment = null;
        $this->agendaId = null;
        $this->resetValidation();
    }
    
    public function render()
    {
        $lookupService = app(LookupService::class);
        $periods = $lookupService->getCollection('period');
        $categories = $lookupService->getCollection('kategori_event');
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
            $this->jurusanFilter = auth()->user()->jurusan_id;
        }
        
        $agendas = Event::query()
            ->with(['category', 'jurusan'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter !== 'all', fn($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->periodFilter !== 'all', fn($q) => $q->where('period', $this->periodFilter))
            ->when($this->statusFilter === 'active', fn($q) => $q->where('is_active', true))
            ->when($this->statusFilter === 'inactive', fn($q) => $q->where('is_active', false))
            ->when($this->jurusanFilter !== 'all', function ($query) {
                if ($this->jurusanFilter === 'umum') {
                    $query->whereNull('jurusan_id');
                } else {
                    $query->where('jurusan_id', $this->jurusanFilter);
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
        
        return view('livewire.admin.agenda-manager', [
            'agendas' => $agendas,
            'periods' => $periods,
            'categories' => $categories,
            'jurusans' => $jurusans,
        ]);
    }
}
