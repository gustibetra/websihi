<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Services\FileUploadService;
use Illuminate\Support\Str;

class EventService extends BaseService
{
    public function __construct(
        private EventRepository $repository,
        private FileUploadService $fileService
    ) {}

    /**
     * Create event
     */
    public function create(array $data)
    {
        try {
            // Generate slug
            $data['slug'] = $this->generateUniqueSlug($data['title']);

            // Upload image if exists
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $this->fileService->uploadAndResize($data['image'], 'events');
            }

            $event = $this->repository->create($data);
            return $this->success($event, 'Agenda berhasil dibuat');
        } catch (\Exception $e) {
            return $this->error('Gagal membuat agenda', $e->getMessage());
        }
    }

    /**
     * Update event
     */
    public function update($id, array $data)
    {
        try {
            $event = $this->repository->find($id);
            if (!$event) {
                return $this->error('Agenda tidak ditemukan');
            }

            // Generate slug if title changed
            if (isset($data['title']) && $data['title'] !== $event->title) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
            }

            // Handle image upload
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if ($event->image) {
                    $this->fileService->delete($event->image);
                }
                $data['image'] = $this->fileService->uploadAndResize($data['image'], 'events');
            }

            $event = $this->repository->update($id, $data);
            return $this->success($event, 'Agenda berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate agenda', $e->getMessage());
        }
    }

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug(string $title, $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->repository->findBySlug($slug)) {
            if ($excludeId && $this->repository->findBySlug($slug)->id == $excludeId) {
                break;
            }
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get upcoming events
     */
    public function getUpcoming($limit = 10)
    {
        try {
            $events = $this->repository->getUpcoming($limit);
            return $this->success($events);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil agenda', $e->getMessage());
        }
    }

    /**
     * Get all events with filter
     */
    public function getAll(string $search = null, $perPage = 15)
    {
        try {
            $query = $this->repository->query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $query->orderBy('start_datetime', 'desc');
            $events = $query->paginate($perPage);

            return $this->success($events);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil agenda', $e->getMessage());
        }
    }

    /**
     * Get by ID
     */
    public function getById($id)
    {
        try {
            $event = $this->repository->find($id);
            if ($event) {
                return $this->success($event);
            }
            return $this->error('Agenda tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil agenda', $e->getMessage());
        }
    }

    /**
     * Delete event
     */
    public function delete($id)
    {
        try {
            $event = $this->repository->find($id);
            if (!$event) {
                return $this->error('Agenda tidak ditemukan');
            }

            if ($event->image) {
                $this->fileService->delete($event->image);
            }

            $deleted = $this->repository->delete($id);
            if ($deleted) {
                return $this->success(null, 'Agenda berhasil dihapus');
            }
            return $this->error('Gagal menghapus agenda');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus agenda', $e->getMessage());
        }
    }
}

