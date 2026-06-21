<?php

namespace App\Livewire\Admin;

use App\Models\Alumni;
use App\Models\Common;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AlumniManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Filter properties
    public $search = '';
    public $jurusanFilter = 'all';
    public $statusFilter = 'all';
    public $inspiratifFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'tahun_lulus';
    public $sortDirection = 'desc';

    // Bulk Action Properties
    public $selectedItems = [];
    public $selectAll = false;

    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $alumniId = null;
    public $form = [];
    public $photo;
    public $currentPhoto = null;

    // Info modal properties
    public $showInfoModal = false;
    public $selectedAlumni = null;

    // Related data lists
    // Removed public property to load dynamically in render() to avoid hydration empty issues

    protected $queryString = [
        'search' => ['except' => ''],
        'jurusanFilter' => ['as' => 'jurusan', 'except' => 'all'],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
        'inspiratifFilter' => ['as' => 'inspiratif', 'except' => 'all'],
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

    public function updatingJurusanFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingInspiratifFilter()
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

    private function loadRelatedData()
    {
        $this->jurusansList = \App\Models\Program::where('is_active', true)->orderBy('nama')->get();
    }

    public function openInfoModal($id)
    {
        $this->selectedAlumni = Alumni::with('jurusan')->find($id);
        if ($this->selectedAlumni) {
            if (auth()->user()->isAdminJurusan() && $this->selectedAlumni->jurusan_id !== auth()->user()->jurusan_id) {
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
            'gender' => 'male',
            'birth_place' => '',
            'birth_date' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'tahun_lulus' => '',
            'tempat_kerja' => '',
            'jabatan' => '',
            'status_alumni' => '',
            'bidang_pekerjaan' => '',
            'testimoni' => '',
            'is_inspiratif' => false,
            'jurusan_id' => null,
            'order' => 0,
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
        $this->alumniId = $id;

        $alumni = Alumni::find($id);
        if ($alumni) {
            if (auth()->user()->isAdminJurusan() && $alumni->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->form = [
                'name' => $alumni->name,
                'gender' => $alumni->gender,
                'birth_place' => $alumni->birth_place,
                'birth_date' => $alumni->birth_date?->format('Y-m-d'),
                'address' => $alumni->address,
                'phone' => $alumni->phone,
                'email' => $alumni->email,
                'tahun_lulus' => $alumni->tahun_lulus,
                'tempat_kerja' => $alumni->tempat_kerja,
                'jabatan' => $alumni->jabatan,
                'status_alumni' => $alumni->status_alumni,
                'bidang_pekerjaan' => $alumni->bidang_pekerjaan,
                'testimoni' => $alumni->testimoni,
                'is_inspiratif' => $alumni->is_inspiratif,
                'jurusan_id' => $alumni->jurusan_id,
                'order' => $alumni->order,
                'is_active' => $alumni->is_active,
                'photo_cropped' => null,
            ];
            $this->currentPhoto = $alumni->photo;
        }

        $this->showModal = true;
        $this->dispatch('open-modal');
    }

    // Listener untuk mereset bidang pekerjaan jika status bukan bekerja
    public function updatedForm($value, $key)
    {
        if ($key === 'status_alumni') {
            if (!in_array($value, ['Bekerja', 'Bekerja dan Kuliah'])) {
                $this->form['bidang_pekerjaan'] = null;
            }
        }
    }

    // Bulk Actions
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $query = Alumni::query();
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $this->selectedItems = $query
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('tahun_lulus', 'like', '%' . $this->search . '%')
                          ->orWhere('tempat_kerja', 'like', '%' . $this->search . '%')
                          ->orWhere('jabatan', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->jurusanFilter !== 'all', function ($query) {
                    $query->where('jurusan_id', $this->jurusanFilter);
                })
                ->when($this->statusFilter !== 'all', function ($query) {
                    $status = $this->statusFilter === 'active' ? 1 : 0;
                    $query->where('is_active', $status);
                })
                ->when($this->inspiratifFilter !== 'all', function ($query) {
                    $inspiratif = $this->inspiratifFilter === 'yes' ? 1 : 0;
                    $query->where('is_inspiratif', $inspiratif);
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
            $query = Alumni::whereIn('id', $this->selectedItems);
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $alumniList = $query->get();

            foreach ($alumniList as $alumni) {
                if ($alumni->photo) {
                    Storage::disk('public')->delete($alumni->photo);
                }
                $alumni->delete();
            }

            $count = count($alumniList);
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
            $query = Alumni::whereIn('id', $this->selectedItems);
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

    public function save()
    {
        if (auth()->user()->isAdminJurusan()) {
            $this->form['jurusan_id'] = auth()->user()->jurusan_id;
        }

        $this->validate($this->getRules(), [
            'photo.required_without' => 'Foto wajib diunggah untuk data baru.',
        ]);

        try {
            $isWorking = in_array($this->form['status_alumni'] ?? '', ['Bekerja', 'Bekerja dan Kuliah']);
            $data = [
                'name' => $this->form['name'],
                'gender' => $this->form['gender'],
                'birth_place' => $this->form['birth_place'] ?? null,
                'birth_date' => $this->form['birth_date'] ?: null,
                'address' => $this->form['address'] ?? null,
                'phone' => $this->form['phone'] ?? null,
                'email' => $this->form['email'] ?? null,
                'tahun_lulus' => $this->form['tahun_lulus'],
                'tempat_kerja' => $this->form['tempat_kerja'] ?? null,
                'jabatan' => $this->form['jabatan'] ?? null,
                'status_alumni' => $this->form['status_alumni'] ?: null,
                'bidang_pekerjaan' => $isWorking ? ($this->form['bidang_pekerjaan'] ?: null) : null,
                'testimoni' => $this->form['testimoni'] ?? null,
                'is_inspiratif' => $this->form['is_inspiratif'] ?? false,
                'jurusan_id' => $this->form['jurusan_id'] ?: null,
                'order' => $this->form['order'] ?: 0,
                'is_active' => $this->form['is_active'] ?? false,
            ];

            if (auth()->user()->isAdminJurusan()) {
                $data['jurusan_id'] = auth()->user()->jurusan_id;
            }

            // Handle photo upload dengan cropper.js
            if (!empty($this->form['photo_cropped'])) {
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $imageData = $this->form['photo_cropped'];
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
                $imageData = base64_decode($imageData);
                $filename = 'alumni/' . uniqid('alumni_', true) . '.jpg';
                Storage::disk('public')->put($filename, $imageData);
                $data['photo'] = $filename;
            } elseif ($this->photo) {
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $photoPath = $this->photo->store('alumni', 'public');
                $data['photo'] = $photoPath;
            }

            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                $alumni = Alumni::find($this->alumniId);
                $alumni->update($data);
                $message = 'Data Alumni berhasil diupdate';
            } else {
                $data['created_by'] = auth()->id();
                Alumni::create($data);
                $message = 'Data Alumni berhasil ditambahkan';
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
            $alumni = Alumni::find($id);
            if (!$alumni) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            if (auth()->user()->isAdminJurusan() && $alumni->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }

            if ($alumni->photo) {
                Storage::disk('public')->delete($alumni->photo);
            }

            $alumni->delete();

            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Data Alumni berhasil dihapus']);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $alumni = Alumni::find($id);
            if (!$alumni) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            if (auth()->user()->isAdminJurusan() && $alumni->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }

            $alumni->update(['is_active' => !$alumni->is_active]);
            $statusText = $alumni->is_active ? 'diaktifkan' : 'dinonaktifkan';

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Data Alumni berhasil {$statusText}"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function toggleInspiratif($id)
    {
        try {
            $alumni = Alumni::find($id);
            if (!$alumni) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            if (auth()->user()->isAdminJurusan() && $alumni->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }

            $alumni->update(['is_inspiratif' => !$alumni->is_inspiratif]);
            $statusText = $alumni->is_inspiratif ? 'dijadikan inspiratif' : 'dibatalkan status inspiratif';

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Data Alumni berhasil {$statusText}"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function resetForm()
    {
        $this->form = [];
        $this->alumniId = null;
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
            'form.tahun_lulus' => 'required|string|max:4|min:4',
            'form.tempat_kerja' => 'nullable|string|max:150',
            'form.jabatan' => 'nullable|string|max:100',
            'form.status_alumni' => 'nullable|string|max:100',
            'form.bidang_pekerjaan' => 'nullable|string|max:100',
            'form.testimoni' => 'nullable|string',
            'form.is_inspiratif' => 'boolean',
            'form.jurusan_id' => 'nullable|exists:programs,id',
            'form.order' => 'nullable|integer',
            'form.is_active' => 'boolean',
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
        $query = Alumni::with('jurusan');
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
            $this->jurusanFilter = auth()->user()->jurusan_id;
        }

        $alumni = $query
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('tahun_lulus', 'like', '%' . $this->search . '%')
                      ->orWhere('tempat_kerja', 'like', '%' . $this->search . '%')
                      ->orWhere('jabatan', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->jurusanFilter !== 'all', function ($query) {
                $query->where('jurusan_id', $this->jurusanFilter);
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $status = $this->statusFilter === 'active' ? 1 : 0;
                $query->where('is_active', $status);
            })
            ->when($this->inspiratifFilter !== 'all', function ($query) {
                $inspiratif = $this->inspiratifFilter === 'yes' ? 1 : 0;
                $query->where('is_inspiratif', $inspiratif);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $statusAlumniList = Common::where('table_name', 'status_alumni')->where('is_active', true)->orderBy('data1')->get();
        $bidangPekerjaanList = Common::where('table_name', 'bidang_pekerjaan')->where('is_active', true)->orderBy('data1')->get();

        $jurusansList = \App\Models\Program::where('is_active', true)->orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusansList = $jurusansList->where('id', auth()->user()->jurusan_id);
        }

        return view('livewire.admin.alumni-manager', [
            'alumni' => $alumni,
            'statusAlumniList' => $statusAlumniList,
            'bidangPekerjaanList' => $bidangPekerjaanList,
            'jurusansList' => $jurusansList,
        ]);
    }
}
