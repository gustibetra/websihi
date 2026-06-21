<?php

namespace App\Livewire\Admin;

use App\Models\Download;
use App\Models\Common;
use App\Models\Program;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DownloadManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Search & Filters
    public $search = '';
    public $categoryFilter = 'all';
    public $jurusanFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Bulk actions
    public $selectedItems = [];
    public $selectAll = false;

    // Form Properties
    public $showModal = false;
    public $showInfoModal = false;
    public $editMode = false;
    public $downloadId = null;
    public $form = [
        'title' => '',
        'category_id' => '',
        'jurusan_id' => '', // Empty string means "umum" (default)
        'description' => '',
        'is_active' => true,
    ];
    public $fileUpload; // uploaded temporary file
    public $existingFilePath = null;
    public $existingFileSize = null;

    // View Modal Properties
    public $selectedDownload = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['as' => 'category', 'except' => 'all'],
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
        $this->selectedDownload = Download::with(['category', 'jurusan', 'creator', 'updater'])->find($id);
        if ($this->selectedDownload) {
            if (auth()->user()->isAdminJurusan() && $this->selectedDownload->jurusan_id !== auth()->user()->jurusan_id) {
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
            'title' => '',
            'category_id' => '',
            'jurusan_id' => '', // Default to umum
            'description' => '',
            'is_active' => true,
        ];

        $this->showModal = true;
        $this->dispatch('open-modal');
    }

    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->downloadId = $id;

        $download = Download::find($id);
        if ($download) {
            if (auth()->user()->isAdminJurusan() && $download->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->form = [
                'title' => $download->title,
                'category_id' => $download->category_id,
                'jurusan_id' => $download->jurusan_id ?? '',
                'description' => $download->description ?? '',
                'is_active' => $download->is_active,
            ];
            $this->existingFilePath = $download->file_path;
            $this->existingFileSize = $download->file_size;
        }

        $this->showModal = true;
        $this->dispatch('open-modal');
    }

    public function save()
    {
        if (auth()->user()->isAdminJurusan()) {
            $this->form['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $rules = [
            'form.title' => 'required|string|max:255',
            'form.category_id' => 'required|exists:common,id',
            'form.jurusan_id' => 'nullable|exists:programs,id',
            'form.description' => 'nullable|string',
            'form.is_active' => 'boolean',
        ];

        if ($this->editMode) {
            $rules['fileUpload'] = 'nullable|file|max:20480'; // Max 20MB
        } else {
            $rules['fileUpload'] = 'required|file|max:20480'; // Max 20MB
        }

        $this->validate($rules);

        try {
            $filePath = $this->existingFilePath;
            $fileSize = $this->existingFileSize;

            if ($this->fileUpload) {
                // Delete old file if updating
                if ($this->editMode && $this->existingFilePath) {
                    Storage::disk('public')->delete($this->existingFilePath);
                }

                $filePath = $this->fileUpload->store('downloads', 'public');
                $fileSize = $this->formatBytes($this->fileUpload->getSize());
            }

            $data = [
                'title' => $this->form['title'],
                'category_id' => $this->form['category_id'],
                'jurusan_id' => $this->form['jurusan_id'] ?: null, // Empty string means "umum" (null)
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'description' => $this->form['description'] ?? null,
                'is_active' => $this->form['is_active'],
            ];

            if (auth()->user()->isAdminJurusan()) {
                $data['jurusan_id'] = auth()->user()->jurusan_id;
            }

            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                Download::find($this->downloadId)->update($data);
                $message = 'Dokumen berhasil diupdate!';
            } else {
                $data['created_by'] = auth()->id();
                Download::create($data);
                $message = 'Dokumen berhasil ditambahkan!';
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
            $download = Download::find($id);
            if ($download) {
                if (auth()->user()->isAdminJurusan() && $download->jurusan_id !== auth()->user()->jurusan_id) {
                    abort(403, 'Unauthorized action.');
                }
                if ($download->file_path) {
                    Storage::disk('public')->delete($download->file_path);
                }
                $download->delete();
                $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Dokumen berhasil dihapus']);
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal menghapus dokumen: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $download = Download::find($id);
            if ($download) {
                if (auth()->user()->isAdminJurusan() && $download->jurusan_id !== auth()->user()->jurusan_id) {
                    abort(403, 'Unauthorized action.');
                }
                $download->update(['is_active' => !$download->is_active]);
                $statusText = $download->is_active ? 'diaktifkan' : 'dinonaktifkan';
                $this->dispatch('show-toast', ['type' => 'success', 'message' => "Dokumen berhasil {$statusText}"]);
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal mengubah status: ' . $e->getMessage()]);
        }
    }

    // Bulk Actions
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $query = Download::query();
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $this->selectedItems = $query
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%');
                })
                ->when($this->categoryFilter !== 'all', function ($query) {
                    $query->where('category_id', $this->categoryFilter);
                })
                ->when($this->jurusanFilter !== 'all', function ($query) {
                    if ($this->jurusanFilter === 'umum') {
                        $query->whereNull('jurusan_id');
                    } else {
                        $query->where('jurusan_id', $this->jurusanFilter);
                    }
                })
                ->pluck('id')
                ->map(fn($id) => (string)$id)
                ->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function bulkDelete()
    {
        if (empty($this->selectedItems)) return;

        try {
            $query = Download::whereIn('id', $this->selectedItems);
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $downloads = $query->get();
            foreach ($downloads as $dl) {
                if ($dl->file_path) {
                    Storage::disk('public')->delete($dl->file_path);
                }
                $dl->delete();
            }

            $count = count($downloads);
            $this->selectedItems = [];
            $this->selectAll = false;
            $this->dispatch('show-toast', ['type' => 'success', 'message' => "{$count} dokumen berhasil dihapus"]);
            $this->dispatch('bulk-action-completed');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal menghapus beberapa dokumen: ' . $e->getMessage()]);
        }
    }

    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedItems)) return;

        try {
            $query = Download::whereIn('id', $this->selectedItems);
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $query->update([
                'is_active' => $status,
                'updated_by' => auth()->id()
            ]);

            $count = count($this->selectedItems); // simplifications
            $this->selectedItems = [];
            $this->selectAll = false;
            $statusText = $status ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('show-toast', ['type' => 'success', 'message' => "Data berhasil {$statusText}"]);
            $this->dispatch('bulk-action-completed');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal mengubah status beberapa dokumen: ' . $e->getMessage()]);
        }
    }

    private function resetForm()
    {
        $this->form = [
            'title' => '',
            'category_id' => '',
            'jurusan_id' => '', // Default to umum
            'description' => '',
            'is_active' => true,
        ];
        $this->downloadId = null;
        $this->fileUpload = null;
        $this->existingFilePath = null;
        $this->existingFileSize = null;
        $this->resetValidation();
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function render()
    {
        $query = Download::query()
            ->with(['category', 'jurusan', 'creator']);

        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
            $this->jurusanFilter = auth()->user()->jurusan_id;
        }

        $downloads = $query
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter !== 'all', function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->jurusanFilter !== 'all', function ($query) {
                if ($this->jurusanFilter === 'umum') {
                    $query->whereNull('jurusan_id');
                } else {
                    $query->where('jurusan_id', $this->jurusanFilter);
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $jurusans = Program::where('is_active', true)->orderBy('order')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }

        return view('livewire.admin.download-manager', [
            'downloads' => $downloads,
            'kategoris' => Common::where('table_name', 'kategori_download')->where('is_active', true)->get(),
            'jurusans' => $jurusans,
        ]);
    }
}
