<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MitraIndustriManager extends Component
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
        'data1'          => '', // Nama Mitra
        'data2'          => '', // Website
        'data4'          => '', // Bidang Industri
        'data5'          => '', // Kontak/Telepon
        'text1'          => '', // Deskripsi singkat
        'text2'          => '', // Alamat
        'text3'          => '', // Profil
        'jenis_kerjasama' => [],
        'is_active'      => true,
    ];

    public $logo = null;
    public $existingLogo = null;

    // Bulk action
    public $selectedItems = [];
    public $selectAll = false;

    // Related data
    public $jenisKerjasamaOptions = [];
    public $bidangIndustriOptions = [];

    protected $rules = [
        'form.data1'           => 'required|string|max:255',
        'form.data2'           => 'nullable|url|max:255',
        'form.data4'           => 'nullable|string|max:255',
        'form.data5'           => 'nullable|string|max:100',
        'form.text1'           => 'nullable|string',
        'form.text2'           => 'nullable|string',
        'form.text3'           => 'nullable|string',
        'form.jenis_kerjasama' => 'nullable|array',
        'form.is_active'       => 'nullable|boolean',
        'logo'                 => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'form.data1.required' => 'Nama mitra wajib diisi.',
        'form.data2.url'      => 'Format URL website tidak valid.',
        'logo.image'          => 'File harus berupa gambar.',
        'logo.max'            => 'Ukuran logo tidak boleh lebih dari 2 MB.',
    ];

    public function mount()
    {
        if (auth()->user()->isAdminJurusan()) {
            abort(403, 'Unauthorized action.');
        }
        $this->loadOptions();
    }

    private function loadOptions()
    {
        $this->jenisKerjasamaOptions = DB::table('common')
            ->where('table_name', 'jenis_kerjasama')
            ->where('is_active', 1)
            ->orderBy('data1')
            ->get(['id', 'data1'])
            ->toArray();

        $this->bidangIndustriOptions = DB::table('common')
            ->where('table_name', 'bidang_industri')
            ->where('is_active', 1)
            ->orderBy('data1')
            ->get(['id', 'data1'])
            ->toArray();
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
        $this->dispatch('open-mitra-modal', ['jenisKerjasama' => [], 'bidangIndustri' => '']);
    }

    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->dataId = $id;

        $item = DB::table('common')->where('id', $id)->first();
        if ($item) {
            $jenisKerjasama = [];
            if (!empty($item->data6)) {
                $jenisKerjasama = array_filter(explode(';', $item->data6));
            }
            $this->form = [
                'data1'           => $item->data1 ?? '',
                'data2'           => $item->data2 ?? '',
                'data4'           => $item->data4 ?? '',
                'data5'           => $item->data5 ?? '',
                'text1'           => $item->text1 ?? '',
                'text2'           => $item->text2 ?? '',
                'text3'           => $item->text3 ?? '',
                'jenis_kerjasama' => $jenisKerjasama,
                'is_active'       => (bool) $item->is_active,
            ];
            $this->existingLogo = $item->data3 ?? null;
        }

        $this->showModal = true;
        $this->dispatch('open-mitra-modal', [
            'jenisKerjasama' => $this->form['jenis_kerjasama'],
            'bidangIndustri' => $this->form['data4'] ?? '',
        ]);
    }

    public function openInfoModal($id)
    {
        $this->selectedItem = DB::table('common')->where('id', $id)->first();
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
            $logoPath = $this->logo->store('mitra_industri', 'public');
        }

        $data = [
            'data1'      => $this->form['data1'],
            'data2'      => $this->form['data2'] ?? null,
            'data4'      => $this->form['data4'] ?? null,
            'data5'      => $this->form['data5'] ?? null,
            'text1'      => $this->form['text1'] ?? null,
            'text2'      => $this->form['text2'] ?? null,
            'text3'      => $this->form['text3'] ?? null,
            'data6'      => !empty($this->form['jenis_kerjasama']) ? implode(';', $this->form['jenis_kerjasama']) : null,
            'is_active'  => !empty($this->form['is_active']) ? 1 : 0,
            'updated_by' => auth()->id(),
        ];

        if ($logoPath) {
            $data['data3'] = $logoPath;
        }

        if ($this->editMode) {
            DB::table('common')->where('id', $this->dataId)->update($data);
            $msg = 'Mitra DU/DI berhasil diperbarui!';
        } else {
            $data['table_name'] = 'mitra_industri';
            $data['created_by'] = auth()->id();
            DB::table('common')->insert($data);
            $msg = 'Mitra DU/DI berhasil ditambahkan!';
        }

        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('show-toast', ['type' => 'success', 'message' => $msg]);
    }

    public function delete($id)
    {
        $item = DB::table('common')->where('id', $id)->first();
        if ($item && !empty($item->data3)) {
            Storage::disk('public')->delete($item->data3);
        }
        DB::table('common')->where('id', $id)->delete();
        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Mitra DU/DI berhasil dihapus!']);
    }

    public function toggleStatus($id)
    {
        $item = DB::table('common')->where('id', $id)->first();
        if ($item) {
            DB::table('common')->where('id', $id)->update([
                'is_active'  => $item->is_active ? 0 : 1,
                'updated_by' => auth()->id(),
            ]);
            $status = $item->is_active ? 'dinonaktifkan' : 'diaktifkan';
            $this->dispatch('show-toast', ['type' => 'success', 'message' => "Mitra DU/DI berhasil {$status}!"]);
        }
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $query = DB::table('common')->where('table_name', 'mitra_industri');

            if ($this->search) {
                $query->where(function($q) {
                    $q->where('data1', 'like', '%' . $this->search . '%')
                      ->orWhere('data4', 'like', '%' . $this->search . '%')
                      ->orWhere('data2', 'like', '%' . $this->search . '%');
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
        DB::table('common')->whereIn('id', $this->selectedItems)->update([
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
        $items = DB::table('common')->whereIn('id', $this->selectedItems)->get();
        foreach ($items as $item) {
            if (!empty($item->data3)) {
                Storage::disk('public')->delete($item->data3);
            }
        }
        DB::table('common')->whereIn('id', $this->selectedItems)->delete();
        $this->selectedItems = [];
        $this->selectAll = false;
        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Data terpilih berhasil dihapus!']);
        $this->dispatch('bulk-action-completed');
    }

    private function resetForm()
    {
        $this->form = [
            'data1'           => '',
            'data2'           => '',
            'data4'           => '',
            'data5'           => '',
            'text1'           => '',
            'text2'           => '',
            'text3'           => '',
            'jenis_kerjasama' => [],
            'is_active'       => true,
        ];
        $this->dataId = null;
        $this->logo = null;
        $this->existingLogo = null;
        $this->resetValidation();
    }

    public function render()
    {
        $query = DB::table('common')->where('table_name', 'mitra_industri');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('data1', 'like', '%' . $this->search . '%')
                  ->orWhere('data4', 'like', '%' . $this->search . '%')
                  ->orWhere('data2', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
        }

        $mitra = $query->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage);

        return view('livewire.admin.mitra-industri-manager', [
            'mitra' => $mitra,
        ]);
    }
}
