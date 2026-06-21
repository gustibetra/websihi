<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TestimonialManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Filter properties
    public $search = '';
    public $statusFilter = 'all';
    public $perPage = 15;
    public $sortBy = 'order';
    public $sortDirection = 'asc';

    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $testimonialId = null;
    public $form = [];
    public $photo;
    public $currentPhoto = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['as' => 'status', 'except' => 'all'],
    ];

    public function updatingSearch()
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

        $this->form = [
            'name' => '',
            'role' => '',
            'rating' => 5,
            'content' => '',
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
        $this->testimonialId = $id;

        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $this->form = [
                'name' => $testimonial->name,
                'role' => $testimonial->role,
                'rating' => $testimonial->rating ?? 5,
                'content' => $testimonial->content,
                'order' => $testimonial->order,
                'is_active' => $testimonial->is_active,
                'photo_cropped' => null,
            ];
            $this->currentPhoto = $testimonial->photo;
        }

        $this->showModal = true;
        $this->dispatch('open-modal');
    }

    public function save()
    {
        $this->validate($this->getRules());

        try {
            $data = [
                'name' => $this->form['name'],
                'role' => $this->form['role'],
                'rating' => $this->form['rating'] ?? 5,
                'content' => $this->form['content'],
                'order' => $this->form['order'] ?: 0,
                'is_active' => $this->form['is_active'] ?? false,
            ];

            // Handle photo upload dengan cropper.js
            if (!empty($this->form['photo_cropped'])) {
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $imageData = $this->form['photo_cropped'];
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
                $imageData = base64_decode($imageData);
                $filename = 'testimonials/' . uniqid('testimonial_', true) . '.jpg';
                Storage::disk('public')->put($filename, $imageData);
                $data['photo'] = $filename;
            } elseif ($this->photo) {
                if ($this->editMode && $this->currentPhoto) {
                    Storage::disk('public')->delete($this->currentPhoto);
                }
                $photoPath = $this->photo->store('testimonials', 'public');
                $data['photo'] = $photoPath;
            }

            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                $testimonial = Testimonial::find($this->testimonialId);
                $testimonial->update($data);
                $message = 'Testimoni berhasil diupdate';
            } else {
                $data['created_by'] = auth()->id();
                Testimonial::create($data);
                $message = 'Testimoni berhasil ditambahkan';
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
            $testimonial = Testimonial::find($id);
            if (!$testimonial) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }

            $testimonial->delete();

            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Testimoni berhasil dihapus']);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $testimonial = Testimonial::find($id);
            if (!$testimonial) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Data tidak ditemukan']);
                return;
            }

            $testimonial->update(['is_active' => !$testimonial->is_active]);
            $statusText = $testimonial->is_active ? 'diaktifkan' : 'dinonaktifkan';

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => "Testimoni berhasil {$statusText}"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function resetForm()
    {
        $this->form = [];
        $this->testimonialId = null;
        $this->photo = null;
        $this->currentPhoto = null;
        $this->resetValidation();
    }

    public function getRules()
    {
        return [
            'form.name' => 'required|string|max:100',
            'form.role' => 'required|string|max:100',
            'form.rating' => 'required|integer|min:1|max:5',
            'form.content' => 'required|string',
            'form.order' => 'nullable|integer',
            'form.is_active' => 'boolean',
            'photo' => 'nullable|image|max:5120',
        ];
    }

    public function render()
    {
        $testimonials = Testimonial::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('role', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $status = $this->statusFilter === 'active' ? 1 : 0;
                $query->where('is_active', $status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.testimonial-manager', [
            'testimonials' => $testimonials
        ]);
    }
}
