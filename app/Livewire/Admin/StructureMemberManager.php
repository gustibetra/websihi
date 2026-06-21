<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Common;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\StructuralMember;
use App\Models\Alumni;
use App\Models\StructureMember;
use App\Models\StructureSection;
use Illuminate\Support\Facades\DB;

class StructureMemberManager extends Component
{
    public $structureId;
    public $structure;
    public $period;
    
    // SDM Type selection
    public $selectedSdmType = 'teacher';
    
    // Search
    public $searchAvailable = '';
    public $searchAssigned = '';
    
    // Bulk selection
    public $selectedMembers = [];
    public $selectAll = false;
    
    // Member Modal properties
    public $showPositionModal = false;
    public $selectedMemberId = null;
    public $selectedPosition = '';
    public $selectedSectionId = '';
    
    // Bulk Add Modal
    public $showBulkModal = false;
    public $bulkPosition = '';
    public $bulkSectionId = '';
    
    // Section Modal properties
    public $showSectionModal = false;
    public $editingSectionId = null;
    public $sectionName = '';
    
    // Lookup data
    public $positions = [];
    public $sections = [];
    
    protected $queryString = [
        'selectedSdmType' => ['as' => 'sdm_type', 'except' => 'teacher'],
        'searchAvailable' => ['except' => ''],
        'searchAssigned' => ['except' => ''],
    ];
    
    public function mount($structureId)
    {
        $this->structureId = $structureId;
        
        // Load structure
        $this->structure = Common::where('table_name', 'structure')->findOrFail($structureId);
        
        if (auth()->user()->isAdminJurusan()) {
            if (in_array($this->structure->data5, ['sekolah', 'yayasan'])) {
                abort(403, 'Unauthorized action.');
            }
            if ($this->structure->data3 != auth()->user()->jurusan_id) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        // Get period from structure
        $periodCommon = Common::where('table_name', 'period')->find($this->structure->data2);
        $this->period = $periodCommon ? $periodCommon->data1 : ''; // Period value (e.g. "2024-2029")
        
        // Set default SDM type based on structure type
        $structureType = $this->structure->data5;
        if ($structureType === 'yayasan') {
            $this->selectedSdmType = 'structural';
        } elseif (in_array($structureType, ['organisasi', 'ekskul'])) {
            $this->selectedSdmType = 'student';
        } else {
            $this->selectedSdmType = 'teacher';
        }
        
        // Load positions & sections
        $this->loadPositions();
        $this->loadSections();
    }
    
    public function selectSdmType($type)
    {
        $this->selectedSdmType = $type;
        $this->selectedMembers = [];
        $this->selectAll = false;
        $this->searchAvailable = '';
    }
    
    public function loadPositions()
    {
        $this->positions = Common::where('table_name', 'jabatan_organisasi')
            ->where('is_active', true)
            ->orderBy('data1')
            ->get()
            ->map(fn($p) => ['id' => $p->id, 'name' => $p->data1])
            ->toArray();
    }
    
    public function loadSections()
    {
        $this->sections = StructureSection::where('common_id', $this->structureId)
            ->orderBy('order')
            ->get();
    }
    
    // ─── Section Management ──────────────────────────────────────────────────
    
    public function openCreateSectionModal()
    {
        $this->editingSectionId = null;
        $this->sectionName = '';
        $this->showSectionModal = true;
    }
    
    public function openEditSectionModal($id)
    {
        $section = StructureSection::where('common_id', $this->structureId)->findOrFail($id);
        $this->editingSectionId = $id;
        $this->sectionName = $section->name;
        $this->showSectionModal = true;
    }
    
    public function saveSection()
    {
        $this->validate([
            'sectionName' => 'required|string|max:100',
        ], [
            'sectionName.required' => 'Nama section wajib diisi',
        ]);
        
        try {
            if ($this->editingSectionId) {
                $section = StructureSection::where('common_id', $this->structureId)->findOrFail($this->editingSectionId);
                $section->update(['name' => $this->sectionName]);
                $message = 'Section berhasil diupdate';
            } else {
                $maxOrder = StructureSection::where('common_id', $this->structureId)->max('order') ?? 0;
                StructureSection::create([
                    'common_id' => $this->structureId,
                    'name' => $this->sectionName,
                    'order' => $maxOrder + 1
                ]);
                $message = 'Section berhasil dibuat';
            }
            
            $this->showSectionModal = false;
            $this->loadSections();
            $this->dispatch('show-toast', ['type' => 'success', 'message' => $message]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal menyimpan section: ' . $e->getMessage()]);
        }
    }
    
    public function deleteSection($id)
    {
        try {
            $section = StructureSection::where('common_id', $this->structureId)->findOrFail($id);
            
            // Set section_id of members in this section to null (unassigned)
            StructureMember::where('section_id', $id)->update(['section_id' => null]);
            
            $section->delete();
            $this->loadSections();
            
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Section berhasil dihapus']);
            $this->dispatch('member-added'); // Triggers Sortable refresh
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal menghapus section: ' . $e->getMessage()]);
        }
    }
    
    // ─── Member Assignment ───────────────────────────────────────────────────
    
    public function addMember($memberId, $sectionId = null)
    {
        $this->selectedMemberId = $memberId;
        $this->selectedPosition = '';
        
        if ($sectionId) {
            $this->selectedSectionId = $sectionId;
        } elseif ($this->sections->isNotEmpty()) {
            $this->selectedSectionId = $this->sections->first()->id;
        } else {
            $this->selectedSectionId = '';
        }
        
        $this->showPositionModal = true;
    }
    
    public function savePosition()
    {
        $this->validate([
            'selectedPosition' => 'required|string',
            'selectedSectionId' => 'required|exists:structure_sections,id',
        ], [
            'selectedPosition.required' => 'Jabatan wajib dipilih',
            'selectedSectionId.required' => 'Section wajib dipilih',
        ]);
        
        try {
            $modelClass = $this->getSdmModelClass();
            
            // Check if member already exists
            $exists = StructureMember::where('common_id', $this->structureId)
                ->where('member_id', $this->selectedMemberId)
                ->where('member_type', $modelClass)
                ->where('period', $this->period)
                ->exists();
                
            if ($exists) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Anggota sudah terdaftar di struktur ini']);
                return;
            }
            
            $maxOrder = StructureMember::where('common_id', $this->structureId)
                ->where('period', $this->period)
                ->max('order') ?? 0;
                
            StructureMember::create([
                'common_id' => $this->structureId,
                'section_id' => $this->selectedSectionId,
                'member_id' => $this->selectedMemberId,
                'member_type' => $modelClass,
                'period' => $this->period,
                'position' => $this->selectedPosition,
                'order' => $maxOrder + 1,
                'is_active' => true,
            ]);
            
            $this->showPositionModal = false;
            $this->selectedMembers = array_diff($this->selectedMembers, [$this->selectedMemberId]);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Anggota berhasil ditambahkan']);
            $this->dispatch('member-added');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal menambahkan anggota: ' . $e->getMessage()]);
        }
    }
    
    public function openBulkModal()
    {
        if (empty($this->selectedMembers)) {
            $this->dispatch('show-toast', ['type' => 'warning', 'message' => 'Pilih minimal 1 anggota terlebih dahulu']);
            return;
        }
        
        $this->bulkPosition = '';
        if ($this->sections->isNotEmpty()) {
            $this->bulkSectionId = $this->sections->first()->id;
        } else {
            $this->bulkSectionId = '';
        }
        
        $this->showBulkModal = true;
    }
    
    public function saveBulkMembers()
    {
        $this->validate([
            'bulkPosition' => 'required|string',
            'bulkSectionId' => 'required|exists:structure_sections,id',
        ], [
            'bulkPosition.required' => 'Jabatan wajib dipilih',
            'bulkSectionId.required' => 'Section wajib dipilih',
        ]);
        
        try {
            $modelClass = $this->getSdmModelClass();
            $added = 0;
            $skipped = 0;
            
            $maxOrder = StructureMember::where('common_id', $this->structureId)
                ->where('period', $this->period)
                ->max('order') ?? 0;
                
            foreach ($this->selectedMembers as $memberId) {
                $exists = StructureMember::where('common_id', $this->structureId)
                    ->where('member_id', $memberId)
                    ->where('member_type', $modelClass)
                    ->where('period', $this->period)
                    ->exists();
                    
                if ($exists) {
                    $skipped++;
                    continue;
                }
                
                $maxOrder++;
                StructureMember::create([
                    'common_id' => $this->structureId,
                    'section_id' => $this->bulkSectionId,
                    'member_id' => $memberId,
                    'member_type' => $modelClass,
                    'period' => $this->period,
                    'position' => $this->bulkPosition,
                    'order' => $maxOrder,
                    'is_active' => true,
                ]);
                $added++;
            }
            
            $this->showBulkModal = false;
            $this->selectedMembers = [];
            $this->selectAll = false;
            
            $msg = "Berhasil menambahkan {$added} anggota";
            if ($skipped > 0) {
                $msg .= ", {$skipped} anggota dilewati (sudah ada)";
            }
            
            $this->dispatch('show-toast', ['type' => 'success', 'message' => $msg]);
            $this->dispatch('member-added');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal memproses anggota: ' . $e->getMessage()]);
        }
    }
    
    public function removeMember($id)
    {
        try {
            StructureMember::where('id', $id)->delete();
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Anggota berhasil dihapus dari struktur']);
            $this->dispatch('member-added');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal menghapus anggota: ' . $e->getMessage()]);
        }
    }
    
    public function updatePosition($id, $positionName)
    {
        try {
            StructureMember::where('id', $id)->update(['position' => $positionName]);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Jabatan berhasil diperbarui']);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal memperbarui jabatan: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Drag-and-drop Sortable handler
     */
    public function updateStructureOrders($sectionsPayload)
    {
        try {
            DB::transaction(function() use ($sectionsPayload) {
                foreach ($sectionsPayload as $sectionIdStr => $memberIds) {
                    $sectionId = $sectionIdStr === 'unassigned' ? null : (int)$sectionIdStr;
                    foreach ($memberIds as $index => $memberId) {
                        StructureMember::where('id', $memberId)->update([
                            'section_id' => $sectionId,
                            'order' => $index + 1
                        ]);
                    }
                }
            });
            
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Urutan dan section berhasil diperbarui']);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Gagal memperbarui urutan: ' . $e->getMessage()]);
        }
    }
    
    public function updatedSelectAll($value)
    {
        if ($value) {
            // Fetch available members matching search to select all
            $assignedMemberIds = StructureMember::where('common_id', $this->structureId)
                ->where('period', $this->period)
                ->where('member_type', $this->getSdmModelClass())
                ->pluck('member_id')
                ->toArray();
                
            $availableQuery = $this->getAvailableQuery($assignedMemberIds);
            $this->selectedMembers = $availableQuery->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedMembers = [];
        }
    }
    
    // ─── Helpers ─────────────────────────────────────────────────────────────
    
    public function getSdmModelClass()
    {
        $map = [
            'teacher' => Teacher::class,
            'student' => Student::class,
            'structural' => StructuralMember::class,
            'alumni' => Alumni::class,
        ];
        return $map[$this->selectedSdmType] ?? Teacher::class;
    }
    
    private function getAvailableQuery($assignedMemberIds)
    {
        $model = $this->getSdmModelClass();
        $query = $model::whereNotIn('id', $assignedMemberIds)->where('is_active', true);
        
        $query->when($this->searchAvailable, function($q) {
            $q->where('name', 'like', '%' . $this->searchAvailable . '%');
        });
        
        return $query->orderBy('name');
    }
    
    public function render()
    {
        // 1. Get assigned members
        $assignedMembers = StructureMember::where('common_id', $this->structureId)
            ->where('period', $this->period)
            ->with('member')
            ->orderBy('order')
            ->get();
            
        // Filter assigned members by search
        if ($this->searchAssigned) {
            $assignedMembers = $assignedMembers->filter(function($sm) {
                return $sm->member && stripos($sm->member->name, $this->searchAssigned) !== false;
            });
        }
        
        // 2. Get assigned member IDs *for the current selected SDM type*
        $assignedMemberIds = StructureMember::where('common_id', $this->structureId)
            ->where('period', $this->period)
            ->where('member_type', $this->getSdmModelClass())
            ->pluck('member_id')
            ->toArray();
            
        // 3. Get available members
        $availableMembers = $this->getAvailableQuery($assignedMemberIds)->get();
        
        return view('livewire.admin.structure-member-manager', [
            'availableMembers' => $availableMembers,
            'assignedMembers' => $assignedMembers,
        ]);
    }
}
