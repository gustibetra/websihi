<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\CommonService;
use App\Services\LookupService;
use Illuminate\Support\Facades\DB;

class StructureManager extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    
    // Selected structure type
    public $selectedType = 'sekolah';
    
    // Filter properties
    public $search = '';
    public $periodFilter = 'all';
    public $statusFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'key1';
    public $sortDirection = 'asc';
    
    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $structureId = null;
    public $form = [];
    
    // Lookup data
    public $periods = [];
    public $jurusans = [];
    
    protected $queryString = [
        'selectedType' => ['as' => 'type', 'except' => 'sekolah'],
        'search' => ['except' => ''],
        'periodFilter' => ['as' => 'period', 'except' => 'all'],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
    ];
    
    protected $service;
    protected $lookupService;
    
    public function boot(CommonService $service, LookupService $lookupService)
    {
        $this->service = $service;
        $this->lookupService = $lookupService;
    }
    
    public function mount($type = null)
    {
        if (auth()->user()->isAdminJurusan()) {
            $this->selectedType = $type ?? 'organisasi';
        } else {
            $this->selectedType = $type ?? 'sekolah';
        }
        if (auth()->user()->isAdminJurusan() && in_array($this->selectedType, ['sekolah', 'yayasan'])) {
            abort(403, 'Unauthorized action.');
        }
        $this->loadPeriods();
        $this->loadJurusans();
    }
    
    public function selectType($type)
    {
        if (auth()->user()->isAdminJurusan() && in_array($type, ['sekolah', 'yayasan'])) {
            abort(403, 'Unauthorized action.');
        }
        $this->selectedType = $type;
        $this->search = '';
        $this->periodFilter = 'all';
        $this->statusFilter = 'all';
        $this->sortBy = 'key1';
        $this->sortDirection = 'asc';
        $this->resetPage();
    }
    
    public function updatingSearch()
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
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->form['data4'] = '1'; // Default status Aktif (string for dropdown)
        
        // Set default periode aktif
        $activePeriod = collect($this->periods)->firstWhere('data4', '1');
        if ($activePeriod) {
            $this->form['data2'] = $activePeriod['id'];
        }
        
        $this->showModal = true;
        $this->dispatch('open-modal');
    }
    
    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->structureId = $id;
        
        $result = $this->service->getById($id);
        if ($result['success']) {
            $data = $result['data'];
            if (auth()->user()->isAdminJurusan() && $data->data3 != auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $this->form = [
                'data1' => $data->data1 ?? '', // Nama struktur
                'data2' => $data->data2 ?? '', // Period ID
                'data3' => $data->data3 ?? '', // Jurusan ID (if any)
                'text1' => $data->text1 ?? '', // Details/Deskripsi
                'data4' => $data->data4 ?? '1', // Status (keep as string for dropdown)
            ];
        }
        
        $this->showModal = true;
        $this->dispatch('open-modal');
    }
    
    public function save()
    {
        if (auth()->user()->isAdminJurusan()) {
            $this->form['data3'] = auth()->user()->jurusan_id;
        }
        
        $this->validate($this->getRules());
        
        try {
            $data = [
                'data1' => $this->form['data1'], // Nama struktur
                'data2' => $this->form['data2'], // Period ID
                'data3' => !empty($this->form['data3']) ? $this->form['data3'] : null, // Jurusan ID
                'text1' => $this->form['text1'] ?? null, // Deskripsi
                'data4' => $this->form['data4'] ?? '1', // Status
                'is_active' => ($this->form['data4'] ?? '1') === '1' ? 1 : 0,
                'updated_by' => auth()->id(),
            ];
            
            if ($this->editMode) {
                $result = $this->service->update($this->structureId, $data);
                $message = 'Struktur berhasil diupdate';
            } else {
                // For create, add table_name and structure type
                $data['table_name'] = 'structure';
                $data['key2'] = $this->selectedType; // Structure type
                $data['data5'] = $this->selectedType; // Store structure type
                $data['created_by'] = auth()->id();
                
                // Generates code/key1
                $idGen = app(\App\Services\CommonIdGeneratorService::class);
                $data['key1'] = $idGen->generateId('structure', $this->selectedType);
                
                // Get period value for key3
                $period = collect($this->periods)->firstWhere('id', $this->form['data2']);
                if ($period) {
                    $data['key3'] = $period['data1']; // Period value (e.g. "2024-2029")
                }
                
                $result = $this->service->create($data);
                $message = 'Struktur berhasil dibuat';
            }
            
            if ($result['success']) {
                $this->showModal = false;
                $this->resetForm();
                $this->dispatch('show-toast', [
                    'type' => 'success',
                    'message' => $message
                ]);
            } else {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => $result['message']
                ]);
            }
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
            $result = $this->service->getById($id);
            if ($result['success']) {
                $item = $result['data'];
                if (auth()->user()->isAdminJurusan() && $item->data3 != auth()->user()->jurusan_id) {
                    abort(403, 'Unauthorized action.');
                }
            }
            $result = $this->service->delete($id);
            
            if ($result['success']) {
                $this->dispatch('show-toast', [
                    'type' => 'success',
                    'message' => 'Struktur berhasil dihapus'
                ]);
            } else {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => $result['message']
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    public function toggleStatus($id)
    {
        try {
            $result = $this->service->getById($id);
            
            if (!$result['success']) {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
                return;
            }
            
            $item = $result['data'];
            if (auth()->user()->isAdminJurusan() && $item->data3 != auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
            $newStatus = $item->data4 === '1' ? '0' : '1';
            
            $updateResult = $this->service->update($id, [
                'data4' => $newStatus,
                'is_active' => $newStatus === '1' ? 1 : 0,
                'updated_by' => auth()->id(),
            ]);
            
            if ($updateResult['success']) {
                $statusText = $newStatus === '1' ? 'diaktifkan' : 'dinonaktifkan';
                $this->dispatch('show-toast', [
                    'type' => 'success',
                    'message' => "Status berhasil {$statusText}"
                ]);
            } else {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'message' => $updateResult['message']
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
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
        $query = DB::table('programs');
        if (auth()->user()->isAdminJurusan()) {
            $query->where('id', auth()->user()->jurusan_id);
        }
        $this->jurusans = $query->orderBy('nama')
            ->get()
            ->map(fn($j) => ['id' => $j->id, 'data1' => $j->nama, 'data2' => $j->singkatan])
            ->toArray();
    }
    
    private function resetForm()
    {
        $this->form = [];
        $this->structureId = null;
        $this->resetValidation();
    }
    
    public function getRules()
    {
        return [
            'form.data1' => 'required|string|max:255',
            'form.data2' => 'required|exists:common,id',
            'form.data3' => 'nullable|exists:programs,id',
            'form.text1' => 'nullable|string',
            'form.data4' => 'required|in:0,1',
        ];
    }
    
    public function getTypeTitle()
    {
        $titles = [
            'sekolah' => 'Organisasi Sekolah',
            'organisasi' => 'Organisasi Siswa (OSIS)',
            'ekskul' => 'Ekstrakurikuler',
            'kepanitiaan' => 'Kepanitiaan',
            'yayasan' => 'Struktur Yayasan',
        ];
        
        return $titles[$this->selectedType] ?? 'Struktur';
    }
    
    public function render()
    {
        $repository = app(\App\Repositories\CommonRepository::class);
        
        $filters = [
            'search' => $this->search,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
            'perPage' => $this->perPage,
            'structure_type' => $this->selectedType,
        ];
        
        // Add period filter
        if ($this->periodFilter !== 'all') {
            $filters['period_id'] = $this->periodFilter;
        }
        
        // Add status filter
        if ($this->statusFilter !== 'all') {
            $filters['status'] = $this->statusFilter === 'active' ? '1' : '0';
        }
        
        if (auth()->user()->isAdminJurusan()) {
            $filters['jurusan_id'] = auth()->user()->jurusan_id;
        }
        
        $structures = $repository->getByTableNamePaginated('structure', $filters);
        
        return view('livewire.admin.structure-manager', [
            'structures' => $structures
        ]);
    }
}
