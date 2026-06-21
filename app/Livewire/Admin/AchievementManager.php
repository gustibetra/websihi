<?php

namespace App\Livewire\Admin;

use App\Models\Achievement;
use App\Models\Common;
use App\Models\News;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AchievementManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Search & filters
    public $search = '';
    public $kategoriFilter = 'all';
    public $tingkatFilter = 'all';
    public $typeFilter = 'all';
    public $jurusanFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'date';
    public $sortDirection = 'desc';

    // Bulk actions
    public $selectedItems = [];
    public $selectAll = false;

    // Form
    public $showModal = false;
    public $editMode = false;
    public $achievementId = null;
    public $form = [];
    
    // Multiple Photos
    public $achievementPhotos = []; // for uploaded files
    public $existingPhotos = []; // paths to saved images

    // Student Autocomplete (Multi-select)
    public $studentSearch = '';
    public $studentSearchResults = [];
    public $selectedStudents = [];

    // Sekolah Type Selection
    public $achieverSekolahType = 'sekolah';
    public $selectedJurusanId = '';

    // News Autocomplete
    public $newsSearch = '';
    public $selectedNewsId = null;
    public $selectedNewsTitle = null;
    public $newsSearchResults = [];

    // Info modal
    public $showInfoModal = false;
    public $selectedAchievement = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'kategoriFilter' => ['as' => 'kategori', 'except' => 'all'],
        'tingkatFilter' => ['as' => 'tingkat', 'except' => 'all'],
        'typeFilter' => ['as' => 'type', 'except' => 'all'],
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

    public function updatingKategoriFilter()
    {
        $this->resetPage();
    }

    public function updatingTingkatFilter()
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
        $this->selectedAchievement = Achievement::with(['kategori', 'tingkat', 'news'])->find($id);
        if ($this->selectedAchievement) {
            if (auth()->user()->isAdminJurusan() && $this->selectedAchievement->jurusan_id !== auth()->user()->jurusan_id) {
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
            'type' => 'siswa',
            'title' => '',
            'achiever' => '',
            'student_ids' => '',
            'jurusan_id' => '',
            'kategori_id' => '',
            'tingkat_id' => '',
            'date' => '',
            'organizer' => '',
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
        $this->achievementId = $id;

        $ach = Achievement::find($id);
        if ($ach) {
            if (auth()->user()->isAdminJurusan() && $ach->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->form = [
                'type' => $ach->type,
                'title' => $ach->title,
                'achiever' => $ach->achiever,
                'student_ids' => $ach->student_ids,
                'jurusan_id' => $ach->jurusan_id ?? '',
                'kategori_id' => $ach->kategori_id,
                'tingkat_id' => $ach->tingkat_id,
                'date' => $ach->date?->format('Y-m-d'),
                'organizer' => $ach->organizer,
                'description' => $ach->description,
                'is_active' => $ach->is_active,
            ];

            // Load photos
            if (!empty($ach->photo)) {
                $this->existingPhotos = array_filter(explode(';', $ach->photo));
            }

            // Load students
            if ($ach->type === 'siswa' && !empty($ach->student_ids)) {
                $studentIds = array_filter(explode(',', $ach->student_ids));
                $students = Student::whereIn('id', $studentIds)->get();
                foreach ($students as $st) {
                    $this->selectedStudents[] = ['id' => $st->id, 'name' => $st->name];
                }
            }

            // Load Sekolah / Jurusan type
            if ($ach->type === 'sekolah') {
                if ($ach->jurusan_id) {
                    $this->achieverSekolahType = 'jurusan';
                    $this->selectedJurusanId = $ach->jurusan_id;
                } else {
                    // Check if achiever matches any Jurusan
                    $jurusans = \App\Models\Program::where('is_active', true)->get();
                    $matchedJurusan = $jurusans->first(fn($j) => $j->nama === $ach->achiever);
                    if ($matchedJurusan) {
                        $this->achieverSekolahType = 'jurusan';
                        $this->selectedJurusanId = $matchedJurusan->id;
                    } else {
                        $this->achieverSekolahType = 'sekolah';
                    }
                }
            }

            // Load News relation
            if ($ach->news_id) {
                $news = News::find($ach->news_id);
                if ($news) {
                    $this->selectedNewsId = $news->id;
                    $this->selectedNewsTitle = "ID: {$news->id} - {$news->title}";
                    $this->newsSearch = "ID: {$news->id} - {$news->title}";
                }
            }
        }

        $this->showModal = true;
        $this->dispatch('open-modal');
    }

    public function updatedStudentSearch($value)
    {
        if (empty($value)) {
            $this->studentSearchResults = [];
            return;
        }

        $this->studentSearchResults = Student::query()
            ->where('name', 'like', '%' . $value . '%')
            ->limit(5)
            ->get(['id', 'name'])
            ->toArray();
    }

    public function selectStudent($id, $name)
    {
        if (!in_array($id, array_column($this->selectedStudents, 'id'))) {
            $this->selectedStudents[] = ['id' => $id, 'name' => $name];
        }
        $this->studentSearch = '';
        $this->studentSearchResults = [];
    }

    public function removeSelectedStudent($id)
    {
        $this->selectedStudents = array_values(array_filter($this->selectedStudents, function($st) use ($id) {
            return $st['id'] != $id;
        }));
    }

    public function removePhoto($index)
    {
        if (isset($this->existingPhotos[$index])) {
            $path = $this->existingPhotos[$index];
            Storage::disk('public')->delete($path);
            unset($this->existingPhotos[$index]);
            $this->existingPhotos = array_values($this->existingPhotos);

            if ($this->achievementId) {
                Achievement::find($this->achievementId)->update([
                    'photo' => implode(';', $this->existingPhotos)
                ]);
            }
        }
    }

    public function updatedNewsSearch($value)
    {
        if (empty($value)) {
            $this->newsSearchResults = [];
            return;
        }

        $query = News::query();
        if (is_numeric($value)) {
            $query->where('id', $value)
                  ->orWhere('title', 'like', '%' . $value . '%');
        } else {
            $query->where('title', 'like', '%' . $value . '%');
        }

        $this->newsSearchResults = $query->limit(5)->get(['id', 'title'])->toArray();
    }

    public function selectNews($id, $title)
    {
        $this->selectedNewsId = $id;
        $this->selectedNewsTitle = "ID: {$id} - {$title}";
        $this->newsSearch = "ID: {$id} - {$title}";
        $this->newsSearchResults = [];
    }

    public function clearSelectedNews()
    {
        $this->selectedNewsId = null;
        $this->selectedNewsTitle = null;
        $this->newsSearch = '';
        $this->newsSearchResults = [];
    }

    public function save()
    {
        if (auth()->user()->isAdminJurusan()) {
            $this->form['jurusan_id'] = auth()->user()->jurusan_id;
            if ($this->form['type'] === 'sekolah') {
                $this->achieverSekolahType = 'jurusan';
                $this->selectedJurusanId = auth()->user()->jurusan_id;
            }
        }

        $this->validate($this->getRules());

        try {
            // Determine achiever text and jurusan_id
            $achieverText = '';
            $studentIdsStr = null;
            $jurusanId = null;

            if ($this->form['type'] === 'siswa') {
                $achieverText = implode(', ', array_column($this->selectedStudents, 'name'));
                $studentIdsStr = implode(',', array_column($this->selectedStudents, 'id'));
                $jurusanId = $this->form['jurusan_id'] ?: null;
            } else {
                if ($this->achieverSekolahType === 'jurusan') {
                    $jur = \App\Models\Program::find($this->selectedJurusanId);
                    $achieverText = $jur ? $jur->nama : 'Sekolah';
                    $jurusanId = $this->selectedJurusanId ?: null;
                } else {
                    $achieverText = $this->form['achiever'] ?: 'Sekolah';
                }
            }

            if (auth()->user()->isAdminJurusan()) {
                $jurusanId = auth()->user()->jurusan_id;
                if ($this->form['type'] === 'sekolah') {
                    $this->achieverSekolahType = 'jurusan';
                    $this->selectedJurusanId = auth()->user()->jurusan_id;
                    $jur = \App\Models\Program::find(auth()->user()->jurusan_id);
                    $achieverText = $jur ? $jur->nama : 'Sekolah';
                }
            }

            // Upload new photos
            $uploadedPaths = [];
            if (!empty($this->achievementPhotos)) {
                foreach ($this->achievementPhotos as $photoFile) {
                    $uploadedPaths[] = $photoFile->store('achievements', 'public');
                }
            }

            $allPhotos = array_merge($this->existingPhotos, $uploadedPaths);
            $photoValue = !empty($allPhotos) ? implode(';', $allPhotos) : null;

            $data = [
                'type' => $this->form['type'],
                'title' => $this->form['title'],
                'achiever' => $achieverText,
                'student_ids' => $studentIdsStr,
                'jurusan_id' => $jurusanId,
                'kategori_id' => $this->form['kategori_id'] ?: null,
                'tingkat_id' => $this->form['tingkat_id'] ?: null,
                'date' => $this->form['date'] ?: null,
                'organizer' => $this->form['organizer'] ?? null,
                'description' => $this->form['description'] ?? null,
                'news_id' => $this->selectedNewsId,
                'photo' => $photoValue,
                'is_active' => $this->form['is_active'] ?? false,
            ];

            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                $ach = Achievement::find($this->achievementId);
                $ach->update($data);
                $message = 'Data Prestasi berhasil diupdate';
            } else {
                $data['created_by'] = auth()->id();
                Achievement::create($data);
                $message = 'Data Prestasi berhasil ditambahkan';
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
            $ach = Achievement::find($id);
            if (!$ach) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            if (auth()->user()->isAdminJurusan() && $ach->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }

            // Delete files
            if ($ach->photo) {
                $photos = array_filter(explode(';', $ach->photo));
                foreach ($photos as $p) {
                    Storage::disk('public')->delete($p);
                }
            }

            $ach->delete();

            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Data Prestasi berhasil dihapus']);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $ach = Achievement::find($id);
            if (!$ach) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            if (auth()->user()->isAdminJurusan() && $ach->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }

            $ach->update(['is_active' => !$ach->is_active]);
            $statusText = $ach->is_active ? 'diaktifkan' : 'dinonaktifkan';

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Data Prestasi berhasil {$statusText}"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Bulk actions
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $query = Achievement::query();
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $this->selectedItems = $query
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('achiever', 'like', '%' . $this->search . '%')
                          ->orWhere('organizer', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->kategoriFilter !== 'all', function ($query) {
                    $query->where('kategori_id', $this->kategoriFilter);
                })
                ->when($this->tingkatFilter !== 'all', function ($query) {
                    $query->where('tingkat_id', $this->tingkatFilter);
                })
                ->when($this->typeFilter !== 'all', function ($query) {
                    $query->where('type', $this->typeFilter);
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
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Pilih minimal satu data untuk dihapus']);
            return;
        }

        try {
            $query = Achievement::whereIn('id', $this->selectedItems);
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $achievements = $query->get();
            foreach ($achievements as $ach) {
                if ($ach->photo) {
                    $photos = array_filter(explode(';', $ach->photo));
                    foreach ($photos as $p) {
                        Storage::disk('public')->delete($p);
                    }
                }
                $ach->delete();
            }

            $count = count($achievements);
            $this->selectedItems = [];
            $this->selectAll = false;

            $this->dispatch('show-toast', ['type' => 'success', 'message' => "{$count} data prestasi berhasil dihapus"]);
            $this->dispatch('bulk-action-completed');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Pilih minimal satu data']);
            return;
        }

        try {
            $query = Achievement::whereIn('id', $this->selectedItems);
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $query->update([
                'is_active' => $status,
                'updated_by' => auth()->id()
            ]);

            $count = count($this->selectedItems);
            $this->selectedItems = [];
            $this->selectAll = false;

            $statusText = $status ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('show-toast', ['type' => 'success', 'message' => "{$count} data prestasi berhasil {$statusText}"]);
            $this->dispatch('bulk-action-completed');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function resetForm()
    {
        $this->form = [];
        $this->achievementId = null;
        $this->achievementPhotos = [];
        $this->existingPhotos = [];
        $this->studentSearch = '';
        $this->studentSearchResults = [];
        $this->selectedStudents = [];
        $this->achieverSekolahType = 'sekolah';
        $this->selectedJurusanId = '';
        $this->selectedNewsId = null;
        $this->selectedNewsTitle = null;
        $this->newsSearch = '';
        $this->newsSearchResults = [];
        $this->resetValidation();
    }

    public function getRules()
    {
        $rules = [
            'form.type' => 'required|in:siswa,sekolah',
            'form.title' => 'required|string|max:255',
            'form.jurusan_id' => 'nullable|exists:programs,id',
            'form.kategori_id' => 'nullable|exists:common,id',
            'form.tingkat_id' => 'nullable|exists:common,id',
            'form.date' => 'nullable|date',
            'form.organizer' => 'nullable|string|max:255',
            'form.description' => 'nullable|string',
            'form.is_active' => 'boolean',
        ];

        if ($this->form['type'] === 'siswa') {
            $rules['selectedStudents'] = 'required|array|min:1';
        } else {
            if ($this->achieverSekolahType === 'jurusan') {
                $rules['selectedJurusanId'] = 'required|exists:programs,id';
            } else {
                $rules['form.achiever'] = 'required|string|max:255';
            }
        }

        // Multiple photos validation
        $rules['achievementPhotos.*'] = 'nullable|image|max:5120';

        return $rules;
    }

    public function render()
    {
        $query = Achievement::query()
            ->with(['kategori', 'tingkat', 'news', 'jurusan']);

        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
            $this->jurusanFilter = auth()->user()->jurusan_id;
        }

        $achievements = $query
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('achiever', 'like', '%' . $this->search . '%')
                      ->orWhere('organizer', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->kategoriFilter !== 'all', function ($query) {
                $query->where('kategori_id', $this->kategoriFilter);
            })
            ->when($this->tingkatFilter !== 'all', function ($query) {
                $query->where('tingkat_id', $this->tingkatFilter);
            })
            ->when($this->typeFilter !== 'all', function ($query) {
                $query->where('type', $this->typeFilter);
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
 
        $jurusans = \App\Models\Program::where('is_active', true)->orderBy('order')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusans = $jurusans->where('id', auth()->user()->jurusan_id);
        }

        return view('livewire.admin.achievement-manager', [
            'achievements' => $achievements,
            'kategoris' => Common::getByTable('kategori_prestasi'),
            'tingkats' => Common::getByTable('tingkatan_prestasi'),
            'jurusans' => $jurusans,
        ]);
    }
}
