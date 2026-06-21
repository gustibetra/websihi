<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\CommonService;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CommonDataManager extends Component
{
    use WithPagination, WithFileUploads;

    public $selectedData = '';
    public $search = '';
    public $sortBy = 'key1';
    public $sortDirection = 'asc';
    public $perPage = 8;
    public $hideSidebar = false;

    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $dataId = null;
    public $form = [];
    public $logo; // For Mitra, Organisasi/Ekskul, Sertifikasi, Program Unggulan
    public $fasilitasImages = []; // Multiple images for fasilitas
    public $existingFasilitasImages = []; // Array of paths

    public $periods = [];
    public $jurusans = [];
    public $tingkatKelas = [];

    protected $queryString = [
        'selectedData' => ['as' => 'data', 'except' => ''],
    ];

    protected $service;

    public function boot(CommonService $service)
    {
        $this->service = $service;
    }

    public function mount($data = null, $hideSidebar = false)
    {
        $this->selectedData = $data ?? '';
        $this->hideSidebar = $hideSidebar;
    }

    public function selectData($dataType)
    {
        $this->selectedData = $dataType;
        $this->search = '';
        $this->sortBy = 'key1';
        $this->sortDirection = 'asc';
        $this->resetPage();
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

        $this->loadRelatedData();
        $this->form['is_active'] = true;
        if ($this->getTableName() === 'mitra_industri') {
            $this->form['jenis_kerjasama'] = [];
        }

        $this->showModal = true;
        $this->dispatch('open-modal', ['jenisKerjasama' => []]);
    }

    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->dataId = $id;

        $this->loadRelatedData();

        $result = $this->service->getById($id);
        if ($result['success']) {
            $data = $result['data']->toArray();
            $data['is_active'] = (bool) $data['is_active'];

            if (!empty($data['date1'])) {
                $data['date1'] = Carbon::parse($data['date1'])->format('Y-m-d');
            }
            if (!empty($data['date2'])) {
                $data['date2'] = Carbon::parse($data['date2'])->format('Y-m-d');
            }

            if ($this->getTableName() === 'fasilitas' && !empty($data['data6'])) {
                $this->existingFasilitasImages = array_filter(explode(';', $data['data6']));
            }

            if ($this->getTableName() === 'mitra_industri' && !empty($data['data6'])) {
                $data['jenis_kerjasama'] = array_filter(explode(';', $data['data6']));
            } else {
                $data['jenis_kerjasama'] = [];
            }

            $this->form = $data;
        }

        $this->showModal = true;
        $this->dispatch('open-modal', ['jenisKerjasama' => $this->form['jenis_kerjasama'] ?? []]);
    }

    private function loadRelatedData()
    {
        if (str_starts_with($this->selectedData, 'structure-')) {
            $this->loadPeriods();
            if (!$this->editMode) {
                $activePeriod = collect($this->periods)->firstWhere('data4', '1');
                if ($activePeriod) {
                    $this->form['data2'] = $activePeriod['id'];
                }
            }
        }

        if (in_array($this->selectedData, ['kelas', 'kompetensi_keahlian']) || str_starts_with($this->selectedData, 'structure-')) {
            $this->loadJurusans();
        }

        if ($this->selectedData === 'kelas') {
            $this->loadTingkatKelas();
        }
    }

    private function loadPeriods()
    {
        $this->periods = DB::table('common')
            ->where('table_name', 'period')
            ->orderByDesc('id')
            ->get()
            ->map(fn($p) => ['id' => $p->id, 'data1' => $p->data1, 'data4' => $p->data4])
            ->toArray();
    }

    private function loadJurusans()
    {
        $this->jurusans = DB::table('programs')
            ->orderBy('nama')
            ->get()
            ->map(fn($j) => ['id' => $j->id, 'data1' => $j->nama, 'data2' => $j->singkatan])
            ->toArray();
    }

    private function loadTingkatKelas()
    {
        $this->tingkatKelas = DB::table('common')
            ->where('table_name', 'tingkat_kelas')
            ->where('is_active', true)
            ->orderBy('data2') // urutan
            ->get()
            ->map(fn($t) => ['id' => $t->id, 'data1' => $t->data1])
            ->toArray();
    }

    public function removeFasilitasImage($index)
    {
        if (isset($this->existingFasilitasImages[$index])) {
            $path = $this->existingFasilitasImages[$index];
            Storage::disk('public')->delete($path);
            unset($this->existingFasilitasImages[$index]);
            $this->existingFasilitasImages = array_values($this->existingFasilitasImages);

            $this->service->update($this->dataId, [
                'data6' => implode(';', $this->existingFasilitasImages)
            ]);
        }
    }

    public function save()
    {
        $this->validate();

        $logoPath = null;
        if ($this->logo) {
            $tableName = $this->getTableName();
            $folderMap = [
                'mitra_industri' => 'mitra_industri',
                'sertifikasi'    => 'sertifikasi',
                'program_unggulan' => 'program_unggulan',
            ];
            $folder = $folderMap[$tableName] ?? 'organisasi';

            // Delete old logo if editing
            $logoField = 'data3'; // mitra, sertifikasi, program_unggulan, structure uses data6
            if (in_array($tableName, ['structure'])) $logoField = 'data6';

            if ($this->editMode && !empty($this->form[$logoField])) {
                Storage::disk('public')->delete($this->form[$logoField]);
            }
            $logoPath = $this->logo->store($folder, 'public');
        }

        // Fasilitas multiple images
        $newFasilitasImagesPath = [];
        if (!empty($this->fasilitasImages)) {
            foreach ($this->fasilitasImages as $img) {
                $newFasilitasImagesPath[] = $img->store('fasilitas', 'public');
            }
        }

        $date1 = !empty($this->form['date1']) ? Carbon::parse($this->form['date1'])->format('Y-m-d') : null;
        $date2 = !empty($this->form['date2']) ? Carbon::parse($this->form['date2'])->format('Y-m-d') : null;

        $data = [
            'data1'      => $this->form['data1'] ?? null,
            'data2'      => $this->form['data2'] ?? null,
            'date1'      => $date1,
            'date2'      => $date2,
            'is_active'  => !empty($this->form['is_active']) ? 1 : 0,
            'text1'      => $this->form['text1'] ?? null,
            'updated_by' => auth()->id(),
        ];

        $tableName = $this->getTableName();

        // kelas: data2=tingkat_kelas_id, data3=jurusan_id
        if ($tableName === 'kelas') {
            $data['data3'] = !empty($this->form['data3']) ? $this->form['data3'] : null;
        }

        // kompetensi_keahlian: data2=jurusan_id
        if ($tableName === 'kompetensi_keahlian') {
            $data['data2'] = !empty($this->form['data2']) ? $this->form['data2'] : null;
        }

        // structure: data2=period_id, data3=jurusan_id, data6=logo
        if ($tableName === 'structure') {
            $data['data3'] = !empty($this->form['data3']) ? $this->form['data3'] : null;
            if ($logoPath) $data['data6'] = $logoPath;
        }

        // mitra_industri: data3=logo, data4=bidang, data5=kontak, data6=jenis_kerjasama(;), text2=alamat, text3=profil
        if ($tableName === 'mitra_industri') {
            if ($logoPath) $data['data3'] = $logoPath;
            $data['data4'] = $this->form['data4'] ?? null;
            $data['data5'] = $this->form['data5'] ?? null;
            $data['text2'] = $this->form['text2'] ?? null;
            $data['text3'] = $this->form['text3'] ?? null;
            $data['data6'] = !empty($this->form['jenis_kerjasama']) ? implode(';', $this->form['jenis_kerjasama']) : null;
        }

        // fasilitas: data2=lokasi, data4=kapasitas, data6=images(;)
        if ($tableName === 'fasilitas') {
            $data['data4'] = $this->form['data4'] ?? null;
            $allImages = array_merge($this->existingFasilitasImages, $newFasilitasImagesPath);
            $data['data6'] = !empty($allImages) ? implode(';', $allImages) : null;
        }

        // sertifikasi: data3=logo, data4=lembaga_penerbit
        if ($tableName === 'sertifikasi') {
            if ($logoPath) $data['data3'] = $logoPath;
            $data['data4'] = $this->form['data4'] ?? null;
        }

        // program_unggulan: data3=image, data4=kategori
        if ($tableName === 'program_unggulan') {
            if ($logoPath) $data['data3'] = $logoPath;
            $data['data4'] = $this->form['data4'] ?? null;
        }

        // kurikulum: data4=tahun
        if ($tableName === 'kurikulum') {
            $data['data4'] = $this->form['data4'] ?? null;
        }

        if (!$this->editMode) {
            $data['table_name'] = $tableName;
            $data['created_by'] = auth()->id();

            if ($tableName === 'structure') {
                $structureType = str_replace('structure-', '', $this->selectedData);
                $data['key2'] = $structureType;
                $data['data5'] = $structureType;
            }
        }

        if ($this->editMode) {
            $result = $this->service->update($this->dataId, $data);
            $actionMsg = 'diubah';
        } else {
            $result = $this->service->create($data);
            $actionMsg = 'ditambahkan';
        }

        if ($result['success']) {
            $this->showModal = false;
            $this->resetForm();
            $this->dispatch('show-toast', [
                'type'    => 'success',
                'message' => "Success - {$this->getDataTitle()} berhasil {$actionMsg}"
            ]);
        } else {
            $this->dispatch('show-toast', [
                'type'    => 'error',
                'message' => 'Gagal menyimpan: ' . $result['message']
            ]);
        }
    }

    public function delete($id)
    {
        $getData = $this->service->getById($id);

        if ($getData['success']) {
            $item = $getData['data'];
            $tableName = $this->getTableName();

            if (in_array($tableName, ['mitra_industri', 'sertifikasi', 'program_unggulan']) && !empty($item->data3)) {
                Storage::disk('public')->delete($item->data3);
            }
            if ($tableName === 'structure' && !empty($item->data6)) {
                Storage::disk('public')->delete($item->data6);
            }
            if ($tableName === 'fasilitas' && !empty($item->data6)) {
                foreach (array_filter(explode(';', $item->data6)) as $img) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $result = $this->service->delete($id);

        if ($result['success']) {
            $this->dispatch('show-toast', [
                'type'    => 'success',
                'message' => "Success - {$this->getDataTitle()} berhasil dihapus"
            ]);
        } else {
            $this->dispatch('show-toast', [
                'type'    => 'error',
                'message' => $result['message']
            ]);
        }
    }

    public function togglePeriodActive($id)
    {
        $result = $this->service->togglePeriodActive($id);

        if ($result['success']) {
            $this->dispatch('show-toast', [
                'type'    => 'success',
                'message' => "Success - " . $result['message']
            ]);
        } else {
            $this->dispatch('show-toast', [
                'type'    => 'error',
                'message' => $result['message']
            ]);
        }
    }

    public function toggleStatus($id)
    {
        $result = $this->service->getById($id);

        if (!$result['success']) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
            return;
        }

        $item = $result['data'];
        $newStatus = $item->is_active ? 0 : 1;

        $updateResult = $this->service->update($id, [
            'is_active'  => $newStatus,
            'updated_by' => auth()->id(),
        ]);

        if ($updateResult['success']) {
            $statusText = $newStatus === 1 ? 'diaktifkan' : 'dinonaktifkan';
            $this->dispatch('show-toast', [
                'type'    => 'success',
                'message' => "Success - {$this->getDataTitle()} berhasil {$statusText}"
            ]);
        } else {
            $this->dispatch('show-toast', [
                'type'    => 'error',
                'message' => $updateResult['message']
            ]);
        }
    }

    private function resetForm()
    {
        $this->form = [];
        $this->dataId = null;
        $this->logo = null;
        $this->fasilitasImages = [];
        $this->existingFasilitasImages = [];
        $this->resetValidation();
    }

    public function getTableName()
    {
        $mapping = [
            // Akademik
            'period'               => 'period',
            'tingkat_kelas'        => 'tingkat_kelas',
            'kelas'                => 'kelas',
            'kompetensi_keahlian'  => 'kompetensi_keahlian',
            'kurikulum'            => 'kurikulum',
            // Struktur
            'jabatan_organisasi'   => 'jabatan_organisasi',
            'divisi'               => 'divisi',
            'structure-organisasi' => 'structure',
            'structure-sekolah'    => 'structure',
            'structure-ekskul'     => 'structure',
            'structure-kepanitiaan'=> 'structure',
            // Hubungan Industri
            'mitra_industri'       => 'mitra_industri',
            'jenis_kerjasama'      => 'jenis_kerjasama',
            'bidang_industri'      => 'bidang_industri',
            // Profil Tambahan
            'fasilitas'            => 'fasilitas',
            'sertifikasi'          => 'sertifikasi',
            'program_unggulan'     => 'program_unggulan',
            'kategori_prestasi'    => 'kategori_prestasi',
            'tingkatan_prestasi'   => 'tingkatan_prestasi',
            'faq'                  => 'faq',
            // Alumni
            'status_alumni'        => 'status_alumni',
            'bidang_pekerjaan'     => 'bidang_pekerjaan',
            // Media
            'kategori_berita'      => 'kategori_berita',
            'kategori_event'       => 'kategori_event',
            'kategori_pengumuman'  => 'kategori_pengumuman',
            'kategori_download'    => 'kategori_download',
            'kategori_galeri'      => 'kategori_galeri',
            'tag_konten'           => 'tag_konten',
            // Legacy
            'news_category'        => 'news_category',
            'event_category'       => 'event_category',
            'announcement_category'=> 'announcement_category',
        ];

        return $mapping[$this->selectedData] ?? $this->selectedData;
    }

    public function rules()
    {
        $tableName = $this->getTableName();

        // --- Simple text data (kategori-kategori, status, dll) ---
        $simpleTextTables = [
            'jenis_kerjasama', 'bidang_industri',
            'kategori_prestasi', 'tingkatan_prestasi', 'status_alumni', 'bidang_pekerjaan',
            'jabatan_organisasi', 'divisi',
            'kategori_berita', 'kategori_event', 'kategori_pengumuman',
            'kategori_download', 'kategori_galeri', 'tag_konten',
            'news_category', 'event_category', 'announcement_category',
        ];

        if (in_array($tableName, $simpleTextTables)) {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.text1'    => 'nullable|string',
                'form.is_active'=> 'nullable|boolean',
            ];
        }

        if ($tableName === 'period') {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.date1'    => 'required|date',
                'form.date2'    => 'required|date|after_or_equal:form.date1',
                'form.is_active'=> 'nullable|boolean',
                'form.text1'    => 'nullable|string',
            ];
        }

        if ($tableName === 'tingkat_kelas') {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.data2'    => 'required|integer|min:1', // urutan sorting
                'form.text1'    => 'nullable|string',
                'form.is_active'=> 'nullable|boolean',
            ];
        }

        if ($tableName === 'kelas') {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.data2'    => 'required|exists:common,id', // tingkat_kelas_id (required since it is marked required in UI)
                'form.data3'    => 'nullable|exists:programs,id', // jurusan_id
                'form.text1'    => 'nullable|string',
                'form.is_active'=> 'nullable|boolean',
            ];
        }

        if ($tableName === 'kompetensi_keahlian') {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.data2'    => 'required|exists:programs,id', // jurusan_id (required in UI/database representation)
                'form.text1'    => 'nullable|string',
                'form.is_active'=> 'nullable|boolean',
            ];
        }

        if ($tableName === 'kurikulum') {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.data4'    => 'required|string|max:10', // tahun (required in UI)
                'form.text1'    => 'nullable|string',
                'form.is_active'=> 'nullable|boolean',
            ];
        }

        if ($tableName === 'mitra_industri') {
            return [
                'form.data1'          => 'required|string|max:255',
                'form.data2'          => 'nullable|string|max:255',
                'form.data4'          => 'nullable|string|max:255',
                'form.data5'          => 'nullable|string|max:255',
                'form.text1'          => 'nullable|string',
                'form.text2'          => 'nullable|string',
                'form.text3'          => 'nullable|string',
                'form.is_active'      => 'nullable|boolean',
                'form.jenis_kerjasama'=> 'nullable|array',
                'logo'                => 'nullable|image|max:2048',
            ];
        }

        if ($tableName === 'faq') {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.text1'    => 'required|string',
                'form.is_active'=> 'nullable|boolean',
            ];
        }

        if ($tableName === 'fasilitas') {
            return [
                'form.data1'         => 'required|string|max:255',
                'form.data2'         => 'nullable|string|max:255',
                'form.data4'         => 'nullable|string|max:50',
                'form.text1'         => 'nullable|string',
                'form.is_active'     => 'nullable|boolean',
                'fasilitasImages.*'  => 'nullable|image|max:2048',
            ];
        }

        if ($tableName === 'sertifikasi') {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.data4'    => 'nullable|string|max:255', // lembaga penerbit
                'form.text1'    => 'nullable|string',
                'form.is_active'=> 'nullable|boolean',
                'logo'          => 'nullable|image|max:2048',
            ];
        }

        if ($tableName === 'program_unggulan') {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.data4'    => 'nullable|string|max:255', // kategori program
                'form.text1'    => 'nullable|string',
                'form.is_active'=> 'nullable|boolean',
                'logo'          => 'nullable|image|max:2048',
            ];
        }

        if ($tableName === 'structure') {
            return [
                'form.data1'    => 'required|string|max:255',
                'form.data2'    => 'required|exists:common,id',
                'form.data3'    => 'nullable|exists:programs,id',
                'form.text1'    => 'nullable|string',
                'form.is_active'=> 'nullable|boolean',
                'logo'          => 'nullable|image|max:2048',
            ];
        }

        return [
            'form.data1' => 'required|string|max:255',
            'form.text1' => 'nullable|string',
        ];
    }

    public function getDataTitle()
    {
        $titles = [
            // Akademik
            'period'               => 'Tahun Ajaran / Periode',
            'tingkat_kelas'        => 'Tingkat Kelas',
            'kelas'                => 'Kelas / Rombel',
            'kompetensi_keahlian'  => 'Kompetensi Keahlian',
            'kurikulum'            => 'Kurikulum',
            // Struktur
            'jabatan_organisasi'   => 'Jabatan Organisasi',
            'divisi'               => 'Seksi Bidang / Divisi',
            'structure-organisasi' => 'Organisasi Siswa',
            'structure-sekolah'    => 'Organisasi Sekolah',
            'structure-ekskul'     => 'Ekstrakurikuler',
            'structure-kepanitiaan'=> 'Kepanitiaan',
            // Hubungan Industri
            'mitra_industri'       => 'Mitra Industri (DU/DI)',
            'jenis_kerjasama'      => 'Jenis Kerjasama',
            'bidang_industri'      => 'Bidang Industri',
            // Profil Tambahan
            'fasilitas'            => 'Fasilitas Sekolah',
            'sertifikasi'          => 'Sertifikasi',
            'program_unggulan'     => 'Program Unggulan',
            'kategori_prestasi'    => 'Kategori Prestasi',
            'tingkatan_prestasi'   => 'Tingkatan Prestasi',
            'faq'                  => 'Frequently Asked Questions (FAQ)',
            // Alumni
            'status_alumni'        => 'Status Alumni',
            'bidang_pekerjaan'     => 'Bidang Pekerjaan',
            // Media
            'kategori_berita'      => 'Kategori Berita',
            'kategori_event'       => 'Kategori Event',
            'kategori_pengumuman'  => 'Kategori Pengumuman',
            'kategori_download'    => 'Kategori Unduhan',
            'kategori_galeri'      => 'Kategori Galeri',
            'tag_konten'           => 'Tag Konten',
        ];

        return $titles[$this->selectedData] ?? 'Pilih Kategori Data';
    }

    public function render()
    {
        $data = collect();

        if ($this->selectedData) {
            $filters = [
                'search'        => $this->search,
                'sortBy'        => $this->sortBy,
                'sortDirection' => $this->sortDirection,
                'perPage'       => $this->perPage,
            ];

            if (str_starts_with($this->selectedData, 'structure-')) {
                $filters['structure_type'] = str_replace('structure-', '', $this->selectedData);
            }

            $repository = app(\App\Repositories\CommonRepository::class);
            $data = $repository->getByTableNamePaginated($this->getTableName(), $filters);
        }

        return view('livewire.admin.common-data-manager', ['data' => $data]);
    }
}
