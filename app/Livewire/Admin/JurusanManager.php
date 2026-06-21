<?php

namespace App\Livewire\Admin;

use App\Models\Program;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class JurusanManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $statusFilter = 'all';
    public $perPage = 10;
    public $sortBy = 'id';
    public $sortDirection = 'desc';

    // Form properties
    public $showModal = false;
    public $showInfoModal = false;
    public $editMode = false;
    public $dataId = null;
    public $selectedItem = null;

    public $form = [
        'kode'              => '',
        'singkatan'         => '',
        'nama'              => '',
        'ka_prodi'          => '',
        'akreditasi'        => '',
        'deskripsi'         => '',
        'deskripsi_singkat' => '',
        'visi'              => '',
        'misi'              => '',
        'tujuan'            => '',
        'profil_lulusan'    => '',
        'kurikulum'         => '',
        'video_url'         => '',
        'email'             => '',
        'phone'             => '',
        'tahun_berdiri'     => '',
        'is_active'         => true,
    ];

    public $logo = null;
    public $existingLogo = null;
    public $banner = null;
    public $existingBanner = null;

    // Autocomplete for Head of Department (Ka. Prodi / Ketua Jurusan)
    public $kaProdiSearch = '';
    public $kaProdiSearchResults = [];
    public $selectedKaProdiId = null;
    public $selectedKaProdiName = null;

    // Bulk actions
    public $selectedItems = [];
    public $selectAll = false;

    // Related data options
    public $kurikulumOptions = [];
    public $kompetensiKeahlianOptions = [];
    public $kompetensiKeahlianSelected = [];

    protected function rules()
    {
        return [
            'form.kode'              => 'required|string|max:20|unique:programs,kode,' . ($this->dataId ?? 'NULL') . ',id',
            'form.singkatan'         => 'required|string|max:50',
            'form.nama'              => 'required|string|max:150',
            'form.ka_prodi'          => 'nullable|string|max:150',
            'form.akreditasi'        => 'nullable|string|max:10',
            'form.deskripsi'         => 'nullable|string',
            'form.deskripsi_singkat' => 'nullable|string|max:500',
            'form.visi'              => 'nullable|string',
            'form.misi'              => 'nullable|string',
            'form.tujuan'            => 'nullable|string',
            'form.profil_lulusan'    => 'nullable|string',
            'form.kurikulum'         => 'nullable|string|max:100',
            'form.video_url'         => 'nullable|url|max:500',
            'form.email'             => 'nullable|email|max:100',
            'form.phone'             => 'nullable|string|max:30',
            'form.tahun_berdiri'     => 'nullable|integer|min:1900|max:2099',
            'form.is_active'         => 'nullable|boolean',
            'logo'                   => 'nullable|image|max:2048',
            'banner'                 => 'nullable|image|max:4096',
        ];
    }

    protected $messages = [
        'form.kode.required'      => 'Kode program wajib diisi.',
        'form.kode.unique'        => 'Kode program sudah digunakan.',
        'form.singkatan.required' => 'Singkatan wajib diisi.',
        'form.nama.required'      => 'Nama program wajib diisi.',
        'logo.image'              => 'File harus berupa gambar.',
        'logo.max'                => 'Ukuran logo tidak boleh lebih dari 2 MB.',
    ];

    public function mount()
    {
        if (auth()->user()->isAdminJurusan()) {
            abort(403, 'Unauthorized action.');
        }
        $this->loadOptions();
    }

    public function loadOptions()
    {
        $this->kurikulumOptions = DB::table('common')
            ->where('table_name', 'kurikulum')
            ->where('is_active', 1)
            ->orderBy('data1')
            ->get(['id', 'data1'])
            ->map(fn($item) => ['id' => $item->id, 'data1' => $item->data1])
            ->toArray();

        $this->kompetensiKeahlianOptions = DB::table('common')
            ->where('table_name', 'kompetensi_keahlian')
            ->where('is_active', 1)
            ->orderBy('data1')
            ->get(['id', 'data1'])
            ->map(fn($item) => ['id' => $item->id, 'data1' => $item->data1])
            ->toArray();
    }

    public function updatedKaProdiSearch($value)
    {
        if (empty($value)) {
            $this->kaProdiSearchResults = [];
            return;
        }

        $this->kaProdiSearchResults = Teacher::query()
            ->where('is_active', true)
            ->where('jenis', 'guru')
            ->where(function($q) use ($value) {
                $q->where('name', 'like', '%' . $value . '%')
                  ->orWhere('nip', 'like', '%' . $value . '%');
            })
            ->limit(5)
            ->get(['id', 'name', 'nip'])
            ->toArray();
    }

    public function selectKaProdi($id, $name)
    {
        $this->form['ka_prodi'] = (string) $id;
        $this->selectedKaProdiId = $id;
        $this->selectedKaProdiName = $name;
        $this->kaProdiSearch = $name;
        $this->kaProdiSearchResults = [];
    }

    public function clearKaProdi()
    {
        $this->form['ka_prodi'] = '';
        $this->selectedKaProdiId = null;
        $this->selectedKaProdiName = null;
        $this->kaProdiSearch = '';
        $this->kaProdiSearchResults = [];
    }

    public function updatingSearch()
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

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
        $this->dispatch('open-fasilitas-modal', ['content' => '', 'kompetensiKeahlian' => []]);
    }

    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->dataId = $id;

        $item = Program::find($id);
        if ($item) {
            $this->form = [
                'kode'              => $item->kode,
                'singkatan'         => $item->singkatan,
                'nama'              => $item->nama,
                'ka_prodi'          => $item->ka_prodi ?? '',
                'akreditasi'        => $item->akreditasi ?? '',
                'deskripsi'         => $item->deskripsi ?? '',
                'deskripsi_singkat' => $item->deskripsi_singkat ?? '',
                'visi'              => $item->visi ?? '',
                'misi'              => $item->misi ?? '',
                'tujuan'            => $item->tujuan ?? '',
                'profil_lulusan'    => $item->profil_lulusan ?? '',
                'kurikulum'         => $item->kurikulum ?? '',
                'video_url'         => $item->video_url ?? '',
                'email'             => $item->email ?? '',
                'phone'             => $item->phone ?? '',
                'tahun_berdiri'     => $item->tahun_berdiri ?? '',
                'is_active'         => (bool) $item->is_active,
            ];
            $this->existingLogo = $item->logo;
            $this->existingBanner = $item->banner;

            // Load Ka. Prodi Info if stored as teacher ID
            if ($item->ka_prodi && is_numeric($item->ka_prodi)) {
                $teacher = Teacher::find($item->ka_prodi);
                if ($teacher) {
                    $this->selectedKaProdiId = $teacher->id;
                    $this->selectedKaProdiName = $teacher->name;
                    $this->kaProdiSearch = $teacher->name;
                } else {
                    $this->kaProdiSearch = $item->ka_prodi;
                }
            } else {
                $this->kaProdiSearch = $item->ka_prodi ?? '';
            }

            // Load selected Kompetensi Keahlian
            $this->kompetensiKeahlianSelected = DB::table('common')
                ->where('table_name', 'kompetensi_keahlian')
                ->where('data2', $id)
                ->pluck('id')
                ->map(fn($val) => (string) $val)
                ->toArray();
        }

        $this->showModal = true;
        $this->dispatch('open-fasilitas-modal', [
            'content' => $this->form['deskripsi'],
            'kompetensiKeahlian' => $this->kompetensiKeahlianSelected
        ]);
    }

    public function openInfoModal($id)
    {
        $this->selectedItem = Program::with('kepalaProdi')->find($id);
        $this->showInfoModal = true;
    }

    public function save()
    {
        $this->validate();

        $logoPath = null;
        if ($this->logo) {
            if ($this->editMode && $this->existingLogo) {
                Storage::disk('public')->delete($this->existingLogo);
            }
            $logoPath = $this->logo->store('programs', 'public');
        }

        $bannerPath = null;
        if ($this->banner) {
            if ($this->editMode && $this->existingBanner) {
                Storage::disk('public')->delete($this->existingBanner);
            }
            $bannerPath = $this->banner->store('programs/banners', 'public');
        }

        $kaProdiVal = $this->selectedKaProdiId ?: ($this->form['ka_prodi'] ?: null);

        $data = [
            'kode'              => $this->form['kode'],
            'singkatan'         => $this->form['singkatan'],
            'nama'              => $this->form['nama'],
            'ka_prodi'          => $kaProdiVal,
            'akreditasi'        => $this->form['akreditasi'] ?? null,
            'deskripsi'         => $this->form['deskripsi'] ?? null,
            'deskripsi_singkat' => $this->form['deskripsi_singkat'] ?? null,
            'visi'              => $this->form['visi'] ?? null,
            'misi'              => $this->form['misi'] ?? null,
            'tujuan'            => $this->form['tujuan'] ?? null,
            'profil_lulusan'    => $this->form['profil_lulusan'] ?? null,
            'kurikulum'         => $this->form['kurikulum'] ?? null,
            'video_url'         => $this->form['video_url'] ?? null,
            'email'             => $this->form['email'] ?? null,
            'phone'             => $this->form['phone'] ?? null,
            'tahun_berdiri'     => !empty($this->form['tahun_berdiri']) ? (int)$this->form['tahun_berdiri'] : null,
            'is_active'         => !empty($this->form['is_active']) ? 1 : 0,
            'updated_by'        => auth()->id(),
        ];

        if ($logoPath) {
            $data['logo'] = $logoPath;
        }
        if ($bannerPath) {
            $data['banner'] = $bannerPath;
        }

        DB::transaction(function() use ($data, &$msg) {
            if ($this->editMode) {
                $program = Program::find($this->dataId);
                if ($program) {
                    $program->update($data);
                }
                $programId = $this->dataId;
                $msg = 'Program Jurusan berhasil diperbarui!';
            } else {
                $data['created_by'] = auth()->id();
                $program = Program::create($data);
                $programId = $program->id;
                $msg = 'Program Jurusan berhasil ditambahkan!';
            }

            // Sync Kompetensi Keahlian (data2 in common stores jurusan_id)
            DB::table('common')
                ->where('table_name', 'kompetensi_keahlian')
                ->where('data2', $programId)
                ->update(['data2' => null]);

            if (!empty($this->kompetensiKeahlianSelected)) {
                DB::table('common')
                    ->where('table_name', 'kompetensi_keahlian')
                    ->whereIn('id', $this->kompetensiKeahlianSelected)
                    ->update(['data2' => $programId]);
            }
        });

        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('show-toast', ['type' => 'success', 'message' => $msg]);
        $this->dispatch('close-fasilitas-modal');
    }

    public function delete($id)
    {
        $item = Program::find($id);
        if ($item) {
            if (!empty($item->logo)) {
                Storage::disk('public')->delete($item->logo);
            }
            $item->delete();
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Program Jurusan berhasil dihapus!']);
        }
    }

    public function toggleStatus($id)
    {
        $item = Program::find($id);
        if ($item) {
            $item->update([
                'is_active'  => $item->is_active ? 0 : 1,
                'updated_by' => auth()->id(),
            ]);
            $status = $item->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('show-toast', ['type' => 'success', 'message' => "Program Jurusan berhasil {$status}!"]);
        }
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $query = Program::query();

            if ($this->search) {
                $query->where(function($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('kode', 'like', '%' . $this->search . '%')
                      ->orWhere('singkatan', 'like', '%' . $this->search . '%')
                      ->orWhere('ka_prodi', 'like', '%' . $this->search . '%');
                });
            }

            if ($this->statusFilter !== 'all') {
                $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
            }

            $this->selectedItems = $query->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function bulkUpdateStatus($status)
    {
        if (empty($this->selectedItems)) return;
        Program::whereIn('id', $this->selectedItems)->update([
            'is_active'  => $status,
            'updated_by' => auth()->id(),
        ]);
        $this->selectedItems = [];
        $this->selectAll = false;
        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Status berhasil diperbarui!']);
        $this->dispatch('bulk-action-completed');
    }

    public function bulkDelete()
    {
        if (empty($this->selectedItems)) return;
        $items = Program::whereIn('id', $this->selectedItems)->get();
        foreach ($items as $item) {
            if (!empty($item->logo)) {
                Storage::disk('public')->delete($item->logo);
            }
            $item->delete();
        }
        $this->selectedItems = [];
        $this->selectAll = false;
        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Data terpilih berhasil dihapus!']);
        $this->dispatch('bulk-action-completed');
    }

    private function resetForm()
    {
        $this->form = [
            'kode'              => '',
            'singkatan'         => '',
            'nama'              => '',
            'ka_prodi'          => '',
            'akreditasi'        => '',
            'deskripsi'         => '',
            'deskripsi_singkat' => '',
            'visi'              => '',
            'misi'              => '',
            'tujuan'            => '',
            'profil_lulusan'    => '',
            'kurikulum'         => '',
            'video_url'         => '',
            'email'             => '',
            'phone'             => '',
            'tahun_berdiri'     => '',
            'is_active'         => true,
        ];
        $this->dataId = null;
        $this->logo = null;
        $this->existingLogo = null;
        $this->banner = null;
        $this->existingBanner = null;
        $this->kompetensiKeahlianSelected = [];
        $this->clearKaProdi();
        $this->resetValidation();
    }

    public function render()
    {
        $query = Program::query()->with('kepalaProdi');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('kode', 'like', '%' . $this->search . '%')
                  ->orWhere('singkatan', 'like', '%' . $this->search . '%')
                  ->orWhere('ka_prodi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
        }

        $programs = $query->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage);

        // Fetch Kompetensi Keahlian options from common table
        $kompetensiKeahlian = DB::table('common')
            ->where('table_name', 'kompetensi_keahlian')
            ->where('is_active', 1)
            ->get()
            ->groupBy('data2'); // Group by jurusan_id (stored in data2)

        return view('livewire.admin.jurusan-manager', [
            'programs' => $programs,
            'kompetensiKeahlian' => $kompetensiKeahlian,
        ]);
    }
}
