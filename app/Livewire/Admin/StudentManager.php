<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\Common;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Filter properties
    public $search = '';
    public $kelasFilter = 'all';
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
    public $studentId = null;
    public $form = [];
    public $photo;
    public $currentPhoto = null;

    // Info modal properties
    public $showInfoModal = false;
    public $selectedStudent = null;

    // Related data lists
    // Removed public properties to load them dynamically in render() to avoid hydration empty issues

    protected $queryString = [
        'search' => ['except' => ''],
        'kelasFilter' => ['as' => 'kelas', 'except' => 'all'],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
    ];

    public function mount()
    {
        // No longer load related data here
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKelasFilter()
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

    private function loadRelatedData()
    {
        $this->kelasList = Common::where('table_name', 'kelas')->where('is_active', true)->orderBy('data1')->get();
        $this->jurusansList = \App\Models\Program::where('is_active', true)->orderBy('nama')->get();
    }

    public function openInfoModal($id)
    {
        $this->selectedStudent = Student::with(['kelas', 'jurusan'])->find($id);
        if ($this->selectedStudent) {
            if (auth()->user()->isAdminJurusan() && $this->selectedStudent->jurusan_id !== auth()->user()->jurusan_id) {
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
            'nis' => '',
            'nisn' => '',
            'gender' => 'male',
            'birth_place' => '',
            'birth_date' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'kelas_id' => null,
            'jurusan_id' => auth()->user()->isAdminJurusan() ? auth()->user()->jurusan_id : null,
            'order' => 0,
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
        $this->studentId = $id;

        $student = Student::find($id);
        if ($student) {
            if (auth()->user()->isAdminJurusan() && $student->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->form = [
                'name' => $student->name,
                'nis' => $student->nis,
                'nisn' => $student->nisn,
                'gender' => $student->gender,
                'birth_place' => $student->birth_place,
                'birth_date' => $student->birth_date?->format('Y-m-d'),
                'address' => $student->address,
                'phone' => $student->phone,
                'email' => $student->email,
                'kelas_id' => $student->kelas_id,
                'jurusan_id' => $student->jurusan_id,
                'order' => $student->order,
                'description' => $student->description,
                'is_active' => $student->is_active,
                'photo_cropped' => null,
            ];
            $this->currentPhoto = $student->photo;
        }

        $this->showModal = true;
        $this->dispatch('open-modal');
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
            $data = [
                'name' => $this->form['name'],
                'nis' => $this->form['nis'] ?: null,
                'nisn' => $this->form['nisn'] ?: null,
                'gender' => $this->form['gender'],
                'birth_place' => $this->form['birth_place'] ?? null,
                'birth_date' => $this->form['birth_date'] ?: null,
                'address' => $this->form['address'] ?? null,
                'phone' => $this->form['phone'] ?? null,
                'email' => $this->form['email'] ?? null,
                'kelas_id' => $this->form['kelas_id'] ?: null,
                'jurusan_id' => $this->form['jurusan_id'] ?: null,
                'order' => $this->form['order'] ?: 0,
                'description' => $this->form['description'] ?? null,
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
                $filename = 'students/' . uniqid('student_', true) . '.jpg';
                Storage::disk('public')->put($filename, $imageData);
                $data['photo'] = $filename;
            } elseif ($this->photo) {
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $photoPath = $this->photo->store('students', 'public');
                $data['photo'] = $photoPath;
            }

            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                $student = Student::find($this->studentId);
                $student->update($data);
                $message = 'Data Siswa berhasil diupdate';
            } else {
                $data['created_by'] = auth()->id();
                Student::create($data);
                $message = 'Data Siswa berhasil ditambahkan';
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
            $student = Student::find($id);
            if (!$student) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            if (auth()->user()->isAdminJurusan() && $student->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }

            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }

            $student->delete();

            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Data Siswa berhasil dihapus']);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $student = Student::find($id);
            if (!$student) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            if (auth()->user()->isAdminJurusan() && $student->jurusan_id !== auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }

            $student->update(['is_active' => !$student->is_active]);
            $statusText = $student->is_active ? 'diaktifkan' : 'dinonaktifkan';

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Data Siswa berhasil {$statusText}"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Listener untuk sequential dropdown
    public function updatedForm($value, $key)
    {
        if ($key === 'jurusan_id') {
            $this->form['kelas_id'] = null;
        }
    }

    // Bulk Actions
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $query = Student::query();
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $this->selectedItems = $query
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('nis', 'like', '%' . $this->search . '%')
                          ->orWhere('nisn', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->kelasFilter !== 'all', function ($query) {
                    $query->where('kelas_id', $this->kelasFilter);
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
            $query = Student::whereIn('id', $this->selectedItems);
            if (auth()->user()->isAdminJurusan()) {
                $query->where('jurusan_id', auth()->user()->jurusan_id);
            }
            $students = $query->get();

            foreach ($students as $student) {
                if ($student->photo) {
                    Storage::disk('public')->delete($student->photo);
                }
                $student->delete();
            }

            $count = count($students);
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
            $query = Student::whereIn('id', $this->selectedItems);
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

    private function resetForm()
    {
        $this->form = [];
        $this->studentId = null;
        $this->photo = null;
        $this->currentPhoto = null;
        $this->resetValidation();
    }

    public function getRules()
    {
        $rules = [
            'form.name' => 'required|string|max:100',
            'form.nis' => 'nullable|string|max:20',
            'form.nisn' => 'nullable|string|max:20',
            'form.gender' => 'required|in:male,female',
            'form.birth_place' => 'nullable|string|max:100',
            'form.birth_date' => 'nullable|date',
            'form.address' => 'nullable|string|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.email' => 'nullable|email|max:100',
            'form.kelas_id' => 'nullable|exists:common,id',
            'form.jurusan_id' => 'nullable|exists:programs,id',
            'form.order' => 'nullable|integer',
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
        $query = Student::with(['kelas', 'jurusan']);
        if (auth()->user()->isAdminJurusan()) {
            $query->where('jurusan_id', auth()->user()->jurusan_id);
        }

        $students = $query
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nis', 'like', '%' . $this->search . '%')
                      ->orWhere('nisn', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->kelasFilter !== 'all', function ($query) {
                $query->where('kelas_id', $this->kelasFilter);
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $status = $this->statusFilter === 'active' ? 1 : 0;
                $query->where('is_active', $status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $selectedJurusanId = $this->form['jurusan_id'] ?? null;
        $formKelas = [];
        if ($selectedJurusanId) {
            $formKelas = Common::where('table_name', 'kelas')
                ->where('data3', $selectedJurusanId)
                ->where('is_active', true)
                ->orderBy('data1')
                ->get();
        }

        $kelasListQuery = Common::where('table_name', 'kelas')->where('is_active', true);
        if (auth()->user()->isAdminJurusan()) {
            $kelasListQuery->where('data3', auth()->user()->jurusan_id);
        }
        $kelasList = $kelasListQuery->orderBy('data1')->get();

        $jurusansList = \App\Models\Program::where('is_active', true)->orderBy('nama')->get();
        if (auth()->user()->isAdminJurusan()) {
            $jurusansList = $jurusansList->where('id', auth()->user()->jurusan_id);
        }

        return view('livewire.admin.student-manager', [
            'students' => $students,
            'formKelas' => $formKelas,
            'kelasList' => $kelasList,
            'jurusansList' => $jurusansList,
        ]);
    }
}
