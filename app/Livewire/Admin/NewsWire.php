<?php

namespace App\Livewire\Admin;

use App\Models\News;
use App\Services\LookupService;
use App\Helpers\StorageHelper;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsWire extends Component
{
    use WithPagination;
    
    // Set pagination theme
    protected $paginationTheme = 'bootstrap-5-always';

    public function mount()
    {
        if (auth()->user()->isAdminJurusan()) {
            $this->jurusanFilter = auth()->user()->jurusan_id;
        }
    }

    public $search = '';
    public $status = 'all';
    public $categories = []; // Array of category IDs
    public $periods = []; // Array of periods
    public $dateFrom = '';
    public $dateTo = '';
    public $jurusanFilter = '';
    public $perPage = 10;
    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $showAllFilters = false; // Toggle untuk show/hide filters
    public $selectedItems = []; // Array of selected item IDs
    public $selectAll = false; // Select all checkbox state
    protected $currentPageNews = null; // Cache current page news untuk toggleSelectAll
    protected $skipUpdateSelectAllState = false; // Flag untuk skip updateSelectAllState setelah toggleSelectAll

    // URL query string untuk shareable links
    // Note: 'page' tidak perlu di $queryString karena WithPagination trait sudah handle
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'categories' => ['except' => []],
        'periods' => ['except' => []],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'jurusanFilter' => ['except' => ''],
    ];

    // Reset pagination saat search/filter berubah
    public function updatingSearch()
    {
        $this->resetPage();
        $this->currentPageNews = null; // Clear cache
    }

    public function updatingStatus()
    {
        $this->resetPage();
        $this->currentPageNews = null; // Clear cache
    }

    public function updatingCategories()
    {
        $this->resetPage();
        $this->currentPageNews = null; // Clear cache
    }

    public function updatingPeriods()
    {
        $this->resetPage();
        $this->currentPageNews = null; // Clear cache
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
        $this->currentPageNews = null; // Clear cache
    }

    public function updatingDateTo()
    {
        $this->resetPage();
        $this->currentPageNews = null; // Clear cache
    }

    public function updatingJurusanFilter()
    {
        $this->resetPage();
        $this->currentPageNews = null; // Clear cache
    }

    public function updatingPerPage()
    {
        $this->resetPage();
        $this->currentPageNews = null; // Clear cache
    }

    // Lifecycle hook untuk clear cache saat page berubah
    // DenganPagination trait akan memanggil ini saat page berubah
    public function updatedPage($page)
    {
        // JANGAN clear cache di sini karena render() akan di-panggil setelah ini
        // dan render() akan meng-update cache dengan data page yang benar
        // Hanya update select all state setelah page berubah
        // Cache akan di-update di render() dengan data page yang benar
        $this->updateSelectAllState();
    }

    // Toggle featured status
    public function toggleFeatured($id)
    {
        $news = News::find($id);
        if (!$news) return;

        if (auth()->user()->isAdminJurusan() && $news->jurusan_id !== auth()->user()->jurusan_id) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $news->update(['is_featured' => !$news->is_featured]);
        session()->flash('message', 'Featured status updated.');
    }

    // Delete news
    public function delete($id)
    {
        $news = News::find($id);
        if (!$news) return;

        if (auth()->user()->isAdminJurusan() && $news->jurusan_id !== auth()->user()->jurusan_id) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        StorageHelper::deleteIfExists($news->image);
        StorageHelper::deleteIfExists($news->file);
        $news->delete();
        session()->flash('message', 'News deleted successfully.');
    }

    // Sort table
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // Remove category from filter
    public function removeCategory($categoryId)
    {
        $this->categories = array_values(array_filter($this->categories, fn($id) => $id != $categoryId));
        $this->resetPage();
    }

    // Remove period from filter
    public function removePeriod($period)
    {
        $this->periods = array_values(array_filter($this->periods, fn($p) => $p != $period));
        $this->resetPage();
    }

    // Clear date range
    public function clearDateRange()
    {
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    // Clear all filters
    public function clearAllFilters()
    {
        $this->categories = [];
        $this->periods = [];
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->status = 'all';
        $this->search = '';
        $this->resetPage();
    }

    // Toggle select all - method biasa, bukan lifecycle hook
    public function toggleSelectAll($value)
    {
        try {
            // Gunakan cache currentPageNews yang sudah di-set di render()
            // Cache ini adalah data yang SAMA PERSIS dengan yang ditampilkan di view
            // Jika cache kosong atau null, query ulang menggunakan paginate()
            if ($this->currentPageNews === null || empty($this->currentPageNews)) {
                // Cache kosong, query ulang menggunakan paginate() yang akan otomatis menggunakan $this->page
                $news = News::query()
                    ->with('category')
                    ->when($this->search, function ($query) {
                        $query->where(function ($q) {
                            $q->where('title', 'like', '%' . $this->search . '%')
                              ->orWhere('content', 'like', '%' . $this->search . '%')
                              ->orWhere('tags', 'like', '%' . $this->search . '%');
                        });
                    })
                    ->when($this->status !== 'all', function ($query) {
                        $query->where('status', $this->status);
                    })
                    ->when(!empty($this->categories), function ($query) {
                        $query->whereIn('category_id', $this->categories);
                    })
                    ->when(!empty($this->periods), function ($query) {
                        $query->whereIn('period', $this->periods);
                    })
                    ->when($this->dateFrom && $this->dateTo, function ($query) {
                        $query->whereDate('published_at', '>=', $this->dateFrom)
                              ->whereDate('published_at', '<=', $this->dateTo);
                    })
                    ->when($this->jurusanFilter, function ($query) {
                        if ($this->jurusanFilter === 'umum') {
                            $query->whereNull('jurusan_id');
                        } else {
                            $query->where('jurusan_id', $this->jurusanFilter);
                        }
                    })
                    ->orderBy($this->sortBy, $this->sortDirection)
                    ->paginate($this->perPage);
                
                $currentPageItems = $news->items();
            } else {
                // Gunakan cache yang sudah ada - ini adalah data yang SAMA PERSIS dengan yang ditampilkan
                $currentPageItems = $this->currentPageNews;
            }
            
            // Convert ke array dan extract IDs
            $currentPageItemsArray = is_array($currentPageItems) ? $currentPageItems : collect($currentPageItems)->toArray();
            $currentPageIds = collect($currentPageItemsArray)->pluck('id')->map('intval')->toArray();
            
            if (empty($currentPageIds)) {
                $this->selectAll = false;
                return;
            }
            
            // Convert selectedItems ke array jika belum, dan pastikan semua ID adalah integer
            $selectedItemsArray = is_array($this->selectedItems) 
                ? array_map('intval', array_filter($this->selectedItems, 'is_numeric'))
                : [];
            
            if ($value) {
                // Select all: Pastikan SEMUA item dari current page ada di selectedItems
                // Hapus dulu SEMUA item dari current page yang sudah ada di selectedItems (untuk avoid duplikasi)
                $itemsFromOtherPages = array_values(
                    array_filter($selectedItemsArray, function($id) use ($currentPageIds) {
                        return !in_array((int)$id, $currentPageIds, true);
                    })
                );
                
                // Gabungkan: items dari halaman lain + SEMUA items dari current page (force include semua)
                // Ini akan memastikan SEMUA item di current page ter-select, termasuk yang sudah di-select sebelumnya
                $newSelectedItems = array_values(
                    array_unique(
                        array_merge($itemsFromOtherPages, $currentPageIds),
                        SORT_NUMERIC
                    )
                );
                
                // Sort untuk konsistensi
                sort($newSelectedItems, SORT_NUMERIC);
                
                // Set selectedItems - PASTIKAN semua item di current page ter-select
                $this->selectedItems = $newSelectedItems;
                
                // Verifikasi: pastikan SEMUA item di current page ada di selectedItems
                $missingItems = array_diff($currentPageIds, $this->selectedItems);
                if (!empty($missingItems)) {
                    // Jika ada item yang missing, tambahkan lagi (force)
                    $this->selectedItems = array_values(
                        array_unique(
                            array_merge($this->selectedItems, $missingItems),
                            SORT_NUMERIC
                        )
                    );
                    sort($this->selectedItems, SORT_NUMERIC);
                }
                
                // Force update selectAll state
                $this->selectAll = true;
            } else {
                // Deselect all: Hapus SEMUA item dari current page
                $this->selectedItems = array_values(
                    array_filter($selectedItemsArray, function($id) use ($currentPageIds) {
                        return !in_array((int)$id, $currentPageIds, true);
                    })
                );
                
                // Force update selectAll state
                $this->selectAll = false;
            }
            
            // Set flag untuk skip updateSelectAllState di render()
            $this->skipUpdateSelectAllState = true;
            
            // JANGAN clear cache - biarkan tetap ada untuk konsistensi
            // $this->currentPageNews = null;
            
            // Debug log untuk troubleshooting
            \Log::debug('toggleSelectAll', [
                'value' => $value,
                'currentPageIds' => $currentPageIds,
                'currentPageNewsCount' => $this->currentPageNews ? count($this->currentPageNews) : 0,
                'selectedItemsBefore' => $selectedItemsArray,
                'selectedItemsAfter' => $this->selectedItems,
                'selectAllState' => $this->selectAll,
            ]);
        } catch (\Exception $e) {
            // Fallback jika ada error
            \Log::error('Error in toggleSelectAll: ' . $e->getMessage());
            $this->selectAll = false;
            $this->selectedItems = [];
        }
    }

    // Sync selected items from client-side JavaScript
    // This method is called by JavaScript when selection needs to be synced to server
    public function syncSelectedItems($items)
    {
        // Convert to array and ensure all IDs are integers
        $selectedItemsArray = is_array($items) 
            ? array_map('intval', array_filter($items, 'is_numeric'))
            : [];
        
        // Remove duplicates and sort
        $this->selectedItems = array_values(array_unique($selectedItemsArray, SORT_NUMERIC));
        sort($this->selectedItems, SORT_NUMERIC);
        
        // Update select all state
        $this->updateSelectAllState();
    }

    // Toggle single item selection (kept for backward compatibility, but now handled client-side)
    public function toggleItem($id)
    {
        // Pastikan ID adalah integer
        $id = (int)$id;
        
        // Convert selectedItems ke array jika belum, dan pastikan semua ID adalah integer
        $selectedItemsArray = is_array($this->selectedItems) 
            ? array_map('intval', array_filter($this->selectedItems, 'is_numeric'))
            : [];
        
        if (in_array($id, $selectedItemsArray, true)) {
            // Remove item
            $this->selectedItems = array_values(
                array_filter($selectedItemsArray, fn($item) => (int)$item !== $id)
            );
        } else {
            // Add item
            $selectedItemsArray[] = $id;
            $this->selectedItems = array_values(array_unique($selectedItemsArray, SORT_NUMERIC));
            sort($this->selectedItems, SORT_NUMERIC);
        }
        
        $this->updateSelectAllState();
    }

    // Update select all state based on selected items
    protected function updateSelectAllState()
    {
        try {
            // SELALU query ulang untuk mendapatkan data page yang sedang aktif
            // Jangan bergantung pada cache karena bisa jadi cache dari page sebelumnya
            $currentPageItems = $this->getCurrentPageItems();
            $currentPageIds = $currentPageItems->pluck('id')->map('intval')->toArray();
            
            // Update cache setelah query untuk konsistensi
            $this->currentPageNews = $currentPageItems->toArray();
            
            if (empty($currentPageIds)) {
                $this->selectAll = false;
                return;
            }
            
            // Convert selectedItems ke array jika belum, dan pastikan semua ID adalah integer
            $selectedItemsArray = is_array($this->selectedItems) 
                ? array_map('intval', array_filter($this->selectedItems, 'is_numeric'))
                : [];
            
            // Check if all current page items are selected (menggunakan strict comparison)
            $selectedOnCurrentPage = array_intersect($selectedItemsArray, $currentPageIds);
            $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds) && count($currentPageIds) > 0;
        } catch (\Exception $e) {
            // Fallback jika ada error (misalnya saat component baru mount)
            $this->selectAll = false;
        }
    }

    // Get current page items - menggunakan query yang sama persis dengan render()
    protected function getCurrentPageItems()
    {
        // Gunakan pagination dari Livewire, bukan dari request
        // DenganPagination trait menyediakan $this->page
        // Pastikan kita menggunakan page yang benar dari paginator
        // Gunakan request()->get('page') sebagai fallback jika $this->page belum ter-update
        $currentPage = $this->page ?? request()->get('page', 1);
        
        // Pastikan currentPage adalah integer dan valid
        $currentPage = max(1, (int)$currentPage);
        
        // Build query yang sama persis dengan render()
        $query = News::query()
            ->with('category')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhere('tags', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->when(!empty($this->categories), function ($query) {
                $query->whereIn('category_id', $this->categories);
            })
            ->when(!empty($this->periods), function ($query) {
                $query->whereIn('period', $this->periods);
            })
            ->when($this->dateFrom && $this->dateTo, function ($query) {
                $query->whereDate('published_at', '>=', $this->dateFrom)
                      ->whereDate('published_at', '<=', $this->dateTo);
            })
            ->when($this->jurusanFilter, function ($query) {
                if ($this->jurusanFilter === 'umum') {
                    $query->whereNull('jurusan_id');
                } else {
                    $query->where('jurusan_id', $this->jurusanFilter);
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection);
        
        // Get items untuk current page
        return $query->skip(($currentPage - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
    }

    // Bulk update status
    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih setidaknya satu item.');
            return;
        }

        $query = News::whereIn('id', $this->selectedItems);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }
        $query->update(['status' => $status]);
        $this->selectedItems = [];
        $this->selectAll = false;
        session()->flash('message', 'Status berhasil diperbarui.');
    }

    // Bulk toggle featured
    public function bulkToggleFeatured()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih setidaknya satu item.');
            return;
        }

        $query = News::whereIn('id', $this->selectedItems);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }
        $newsItems = $query->get();
        foreach ($newsItems as $news) {
            $news->update(['is_featured' => !$news->is_featured]);
        }
        
        $this->selectedItems = [];
        $this->selectAll = false;
        session()->flash('message', 'Featured status berhasil diperbarui.');
    }

    // Bulk delete
    public function bulkDelete()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih setidaknya satu item.');
            return;
        }

        $query = News::whereIn('id', $this->selectedItems);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }
        $newsItems = $query->get();
        
        foreach ($newsItems as $news) {
            // Delete image if exists
            StorageHelper::deleteIfExists($news->image);
            // Delete file if exists
            StorageHelper::deleteIfExists($news->file);
            $news->delete();
        }

        $this->selectedItems = [];
        $this->selectAll = false;
        session()->flash('message', count($newsItems) . ' berita berhasil dihapus.');
    }

    public function render()
    {
        // Get lookup data using LookupService
        $lookupService = app(LookupService::class);
        
        // Get categories and periods collections for dropdowns
        $categoriesList = $lookupService->getCollection('kategori_berita');
        $periodsList = $lookupService->getCollection('period');
        
        $jurusans = \App\Models\Program::orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
            $this->jurusanFilter = auth()->user()->jurusan_id;
        }
        
        // Get status options
        $statusOptions = $lookupService->getStatusOptions();

        // Build query
        $news = News::query()
            ->with(['category', 'jurusan'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhere('tags', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->when(!empty($this->categories), function ($query) {
                $query->whereIn('category_id', $this->categories);
            })
            ->when(!empty($this->periods), function ($query) {
                $query->whereIn('period', $this->periods);
            })
            ->when($this->dateFrom && $this->dateTo, function ($query) {
                $query->whereDate('published_at', '>=', $this->dateFrom)
                      ->whereDate('published_at', '<=', $this->dateTo);
            })
            ->when($this->jurusanFilter, function ($query) {
                if ($this->jurusanFilter === 'umum') {
                    $query->whereNull('jurusan_id');
                } else {
                    $query->where('jurusan_id', $this->jurusanFilter);
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        // Cache current page news untuk toggleSelectAll - INI PENTING!
        // Simpan data yang SAMA PERSIS dengan yang ditampilkan di view
        $this->currentPageNews = $news->items();

        // Update select all state - dipanggil setelah query untuk memastikan data sudah ada
        // Update state untuk memastikan checkbox "select all" sinkron dengan selectedItems
        // Skip jika baru saja toggleSelectAll() dipanggil (untuk avoid race condition)
        if (!$this->skipUpdateSelectAllState) {
            $this->updateSelectAllState();
        } else {
            // Reset flag setelah skip
            $this->skipUpdateSelectAllState = false;
        }

        return view('livewire.admin.news-wire', [
            'news' => $news,
            'categoriesList' => $categoriesList,
            'periodsList' => $periodsList,
            'jurusans' => $jurusans,
            'statusOptions' => $statusOptions,
        ]);
    }
}

