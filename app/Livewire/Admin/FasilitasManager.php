<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\CommonService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FasilitasManager extends Component
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
        'data1'     => '', // Nama Fasilitas
        'data2'     => '', // Lokasi
        'data4'     => '', // Kapasitas
        'text1'     => '', // Deskripsi (CKEditor)
        'is_active' => true,
    ];

    public $newImages = [];
    public $existingImages = [];

    // Bulk action
    public $selectedItems = [];
    public $selectAll = false;

    protected $rules = [
        'form.data1'   => 'required|string|max:255',
        'form.data2'   => 'nullable|string|max:255',
        'form.data4'   => 'nullable|string|max:100',
        'form.text1'   => 'nullable|string',
        'form.is_active' => 'nullable|boolean',
        'newImages.*'  => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'form.data1.required' => 'Nama fasilitas wajib diisi.',
        'newImages.*.image'   => 'File harus berupa gambar.',
        'newImages.*.max'     => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
    ];

    public function mount()
    {
        if (auth()->user()->isAdminJurusan()) {
            abort(403, 'Unauthorized action.');
        }
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
        $this->dispatch('open-fasilitas-modal', ['content' => '']);
    }

    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->dataId = $id;

        $item = DB::table('common')->where('id', $id)->first();
        if ($item) {
            $this->form = [
                'data1'     => $item->data1 ?? '',
                'data2'     => $item->data2 ?? '',
                'data4'     => $item->data4 ?? '',
                'text1'     => $item->text1 ?? '',
                'is_active' => (bool) $item->is_active,
            ];
            if (!empty($item->data6)) {
                $this->existingImages = array_filter(explode(';', $item->data6));
            }
        }

        $this->showModal = true;
        $this->dispatch('open-fasilitas-modal', ['content' => $this->form['text1']]);
    }

    public function openInfoModal($id)
    {
        $this->selectedItem = DB::table('common')->where('id', $id)->first();
        $this->showInfoModal = true;
    }

    public function removeImage($index)
    {
        if (isset($this->existingImages[$index])) {
            $path = $this->existingImages[$index];
            Storage::disk('public')->delete($path);
            unset($this->existingImages[$index]);
            $this->existingImages = array_values($this->existingImages);

            DB::table('common')->where('id', $this->dataId)->update([
                'data6' => implode(';', $this->existingImages)
            ]);
        }
    }

    public function save()
    {
        $this->validate();

        $newImagePaths = [];
        if (!empty($this->newImages)) {
            foreach ($this->newImages as $img) {
                $newImagePaths[] = $img->store('fasilitas', 'public');
            }
        }

        $allImages = array_merge($this->existingImages, $newImagePaths);

        $data = [
            'data1'      => $this->form['data1'],
            'data2'      => $this->form['data2'] ?? null,
            'data4'      => $this->form['data4'] ?? null,
            'text1'      => $this->form['text1'] ?? null,
            'is_active'  => !empty($this->form['is_active']) ? 1 : 0,
            'data6'      => !empty($allImages) ? implode(';', $allImages) : null,
            'updated_by' => auth()->id(),
        ];

        if ($this->editMode) {
            DB::table('common')->where('id', $this->dataId)->update($data);
            $msg = 'Fasilitas berhasil diperbarui!';
        } else {
            $data['table_name']  = 'fasilitas';
            $data['created_by']  = auth()->id();
            DB::table('common')->insert($data);
            $msg = 'Fasilitas berhasil ditambahkan!';
        }

        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('show-toast', ['type' => 'success', 'message' => $msg]);
        $this->dispatch('close-fasilitas-modal');
    }

    public function delete($id)
    {
        $item = DB::table('common')->where('id', $id)->first();
        if ($item && !empty($item->data6)) {
            foreach (array_filter(explode(';', $item->data6)) as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        DB::table('common')->where('id', $id)->delete();
        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Fasilitas berhasil dihapus!']);
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
            $this->dispatch('show-toast', ['type' => 'success', 'message' => "Fasilitas berhasil {$status}!"]);
        }
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $query = DB::table('common')->where('table_name', 'fasilitas');

            if ($this->search) {
                $query->where(function($q) {
                    $q->where('data1', 'like', '%' . $this->search . '%')
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
            if (!empty($item->data6)) {
                foreach (array_filter(explode(';', $item->data6)) as $img) {
                    Storage::disk('public')->delete($img);
                }
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
            'data1'     => '',
            'data2'     => '',
            'data4'     => '',
            'text1'     => '',
            'is_active' => true,
        ];
        $this->dataId = null;
        $this->newImages = [];
        $this->existingImages = [];
        $this->resetValidation();
    }

    public function render()
    {
        $query = DB::table('common')->where('table_name', 'fasilitas');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('data1', 'like', '%' . $this->search . '%')
                  ->orWhere('data2', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
        }

        $allowedSorts = ['id', 'data1', 'data2', 'is_active'];
        $sortCol = in_array($this->sortBy, $allowedSorts) ? $this->sortBy : 'id';
        $fasilitas = $query->orderBy($sortCol, $this->sortDirection)->paginate($this->perPage);

        return view('livewire.admin.fasilitas-manager', [
            'fasilitas' => $fasilitas,
        ]);
    }
}
