<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Services\LookupService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PageManager extends Component
{
    use WithPagination, WithFileUploads;
    
    protected $paginationTheme = 'bootstrap';
    
    // Filter properties
    public $search = '';
    public $typeFilter = 'all';
    public $jurusanFilter = 'all';
    public $periodFilter = 'all';
    public $statusFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    

    
    // Info modal properties
    public $showInfoModal = false;
    public $selectedPage = null;
    
    // Bulk action properties
    public $selectedItems = [];
    public $selectAll = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['as' => 'type', 'except' => 'all'],
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
    
    public function updatingTypeFilter()
    {
        $this->resetPage();
    }
    
    public function updatingJurusanFilter()
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
        $this->selectedPage = Page::with(['structure', 'jurusan'])->find($id);
        if ($this->selectedPage) {
            if (auth()->user()->isAdminJurusan() && $this->selectedPage->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->showInfoModal = true;
        }
    }
    
    public function toggleStatus($id)
    {
        $page = Page::find($id);
        if ($page) {
            if (auth()->user()->isAdminJurusan() && $page->jurusan_id !== auth()->user()->jurusan_id) {
                return;
            }
            $page->update(['is_active' => !$page->is_active]);
            session()->flash('message', 'Status halaman berhasil diperbarui.');
        }
    }
    
    public function delete($id)
    {
        $page = Page::find($id);
        if ($page) {
            if (auth()->user()->isAdminJurusan() && $page->jurusan_id !== auth()->user()->jurusan_id) {
                return;
            }
            // Delete files
            if ($page->image && Storage::exists('public/' . $page->image)) {
                Storage::delete('public/' . $page->image);
            }
            if ($page->attachment && Storage::exists('public/' . $page->attachment)) {
                Storage::delete('public/' . $page->attachment);
            }
            
            $page->delete();
            session()->flash('message', 'Halaman berhasil dihapus.');
        }
    }

    
    // Bulk actions
    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih setidaknya satu halaman.');
            return;
        }
        
        $query = Page::whereIn('id', $this->selectedItems);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }
        $query->update(['is_active' => $status]);
        $this->selectedItems = [];
        $this->selectAll = false;
        session()->flash('message', 'Status halaman berhasil diperbarui.');
        $this->dispatch('bulk-action-completed');
    }
    
    public function bulkDelete()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih setidaknya satu halaman.');
            return;
        }
        
        $query = Page::whereIn('id', $this->selectedItems);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }
        $pages = $query->get();
        
        foreach ($pages as $page) {
            // Delete files
            if ($page->image && Storage::exists('public/' . $page->image)) {
                Storage::delete('public/' . $page->image);
            }
            if ($page->attachment && Storage::exists('public/' . $page->attachment)) {
                Storage::delete('public/' . $page->attachment);
            }
            $page->delete();
        }
        
        $this->selectedItems = [];
        $this->selectAll = false;
        session()->flash('message', count($pages) . ' halaman berhasil dihapus.');
        $this->dispatch('bulk-action-completed');
    }
    

    
    public function render()
    {
        $lookupService = app(LookupService::class);
        $periods = $lookupService->getPeriods();
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
            $this->jurusanFilter = auth()->user()->jurusan_id;
        }
        
        $pages = Page::query()
            ->with(['structure', 'jurusan'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->typeFilter !== 'all', fn($q) => $q->where('page_type', $this->typeFilter))
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
        
        return view('livewire.admin.page-manager', [
            'pages' => $pages,
            'periods' => $periods,
            'jurusans' => $jurusans,
        ]);
    }
}
