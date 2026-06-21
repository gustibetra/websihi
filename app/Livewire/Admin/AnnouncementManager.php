<?php

namespace App\Livewire\Admin;

use App\Models\Announcement;
use App\Services\LookupService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementManager extends Component
{
    use WithPagination, WithFileUploads;
    
    protected $paginationTheme = 'bootstrap';
    
    // Filter properties
    public $search = '';
    public $categoryFilter = 'all';
    public $periodFilter = 'all';
    public $statusFilter = 'all';
    public $jurusanFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'start_date';
    public $sortDirection = 'desc';
    
    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $announcementId = null;
    public $form = [];
    public $image;
    public $attachment;
    public $currentImage = null;
    public $currentAttachment = null;
    
    // Info modal properties
    public $showInfoModal = false;
    public $selectedAnnouncement = null;
    
    // Bulk action properties
    public $selectedItems = [];
    public $selectAll = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['as' => 'category', 'except' => 'all'],
        'periodFilter' => ['as' => 'period', 'except' => 'all'],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
        'jurusanFilter' => ['as' => 'jurusan', 'except' => 'all'],
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
    
    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }
    
    public function updatingPeriodFilter()
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    
    public function updatingJurusanFilter()
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
        $this->selectedAnnouncement = Announcement::with(['category', 'jurusan'])->find($id);
        if ($this->selectedAnnouncement) {
            if (auth()->user()->isAdminJurusan() && $this->selectedAnnouncement->jurusan_id !== auth()->user()->jurusan_id) {
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
        $this->announcementId = $id;
        
        $announcement = Announcement::find($id);
        if ($announcement) {
            if (auth()->user()->isAdminJurusan() && $announcement->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->form = [
                'title' => $announcement->title,
                'slug' => $announcement->slug,
                'content' => $announcement->content,
                'excerpt' => $announcement->excerpt,
                'category_id' => $announcement->category_id,
                'jurusan_id' => $announcement->jurusan_id,
                'period' => $announcement->period,
                'start_date' => $announcement->start_date?->format('Y-m-d'),
                'end_date' => $announcement->end_date?->format('Y-m-d'),
                'is_active' => $announcement->is_active,
                'is_public' => $announcement->is_public,
            ];
            $this->currentImage = $announcement->image;
            $this->currentAttachment = $announcement->attachment;
            $this->showModal = true;
            $this->dispatch('modal-opened');
        }
    }
    
    
    public function save()
    {
        $rules = [
            'form.title' => 'required|max:255',
            'form.slug' => 'required|max:150|unique:announcement,slug,' . ($this->announcementId ?? 'NULL'),
            'form.category_id' => 'nullable',
            'form.jurusan_id' => 'nullable|integer|exists:programs,id',
            'form.start_date' => 'nullable|date',
            'form.end_date' => 'nullable|date|after_or_equal:form.start_date',
            'image' => 'nullable|image|max:2048',
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
                $data['image'] = $this->image->store('announcements/images', 'public');
            }
            
            // Handle attachment upload
            if ($this->attachment) {
                if ($this->editMode && $this->currentAttachment) {
                    Storage::delete('public/' . $this->currentAttachment);
                }
                // Store with original filename
                $originalName = $this->attachment->getClientOriginalName();
                $data['attachment'] = $this->attachment->storeAs('announcements/attachments', $originalName, 'public');
            }
            
            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                Announcement::find($this->announcementId)->update($data);
                session()->flash('message', 'Pengumuman berhasil diperbarui.');
            } else {
                $data['created_by'] = auth()->id();
                Announcement::create($data);
                session()->flash('message', 'Pengumuman berhasil ditambahkan.');
            }
            
            $this->showModal = false;
            $this->resetForm();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function toggleStatus($id)
    {
        $announcement = Announcement::find($id);
        if ($announcement) {
            if (auth()->user()->isAdminJurusan() && $announcement->jurusan_id !== auth()->user()->jurusan_id) {
                return;
            }
            $announcement->update(['is_active' => !$announcement->is_active]);
            session()->flash('message', 'Status pengumuman berhasil diperbarui.');
        }
    }
    
    public function delete($id)
    {
        $announcement = Announcement::find($id);
        if ($announcement) {
            if (auth()->user()->isAdminJurusan() && $announcement->jurusan_id !== auth()->user()->jurusan_id) {
                return;
            }
            // Delete files
            if ($announcement->image && Storage::exists('public/' . $announcement->image)) {
                Storage::delete('public/' . $announcement->image);
            }
            if ($announcement->attachment && Storage::exists('public/' . $announcement->attachment)) {
                Storage::delete('public/' . $announcement->attachment);
            }
            
            $announcement->delete();
            session()->flash('message', 'Pengumuman berhasil dihapus.');
        }
    }

    
    // Bulk actions
    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih setidaknya satu pengumuman.');
            return;
        }
        
        $query = Announcement::whereIn('id', $this->selectedItems);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }
        $query->update(['is_active' => $status]);
        $this->selectedItems = [];
        $this->selectAll = false;
        session()->flash('message', 'Status pengumuman berhasil diperbarui.');
    }
    
    public function bulkDelete()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih setidaknya satu pengumuman.');
            return;
        }
        
        $query = Announcement::whereIn('id', $this->selectedItems);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }
        $announcements = $query->get();
        
        foreach ($announcements as $announcement) {
            // Delete files
            if ($announcement->image && Storage::exists('public/' . $announcement->image)) {
                Storage::delete('public/' . $announcement->image);
            }
            if ($announcement->attachment && Storage::exists('public/' . $announcement->attachment)) {
                Storage::delete('public/' . $announcement->attachment);
            }
            $announcement->delete();
        }
        
        $this->selectedItems = [];
        $this->selectAll = false;
        session()->flash('message', count($announcements) . ' pengumuman berhasil dihapus.');
    }
    
    protected function resetForm()
    {
        $this->form = [
            'title' => '',
            'slug' => '',
            'content' => '',
            'excerpt' => '',
            'category_id' => '',
            'jurusan_id' => '',
            'period' => '',
            'start_date' => '',
            'end_date' => '',
            'is_active' => true,
            'is_public' => true,
        ];
        $this->image = null;
        $this->attachment = null;
        $this->currentImage = null;
        $this->currentAttachment = null;
        $this->announcementId = null;
        $this->resetValidation();
    }
    
    public function render()
    {
        $lookupService = app(LookupService::class);
        $periods = $lookupService->getCollection('period');
        $categories = $lookupService->getCollection('kategori_pengumuman');
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
            $this->jurusanFilter = auth()->user()->jurusan_id;
        }
        
        $announcements = Announcement::query()
            ->with(['category', 'jurusan'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->search . '%');
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
        
        return view('livewire.admin.announcement-manager', [
            'announcements' => $announcements,
            'periods' => $periods,
            'categories' => $categories,
            'jurusans' => $jurusans,
        ]);
    }
}
