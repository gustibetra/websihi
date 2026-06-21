<?php

namespace App\Services;

use App\Repositories\AnnouncementRepository;
use App\Services\FileUploadService;
use Illuminate\Support\Str;

class AnnouncementService extends BaseService
{
    public function __construct(
        private AnnouncementRepository $repository,
        private FileUploadService $fileService
    ) {}

    /**
     * Create announcement
     */
    public function create(array $data)
    {
        try {
            // Generate slug
            $data['slug'] = $this->generateUniqueSlug($data['title']);

            // Upload image if exists
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $this->fileService->uploadAndResize($data['image'], 'announcements');
            }

            // Upload banner if exists
            if (isset($data['banner']) && $data['banner'] instanceof \Illuminate\Http\UploadedFile) {
                $data['banner'] = $this->fileService->uploadAndResize($data['banner'], 'announcements', 1200, 400);
            }

            // Upload attachment with original name if exists
            if (isset($data['attachment']) && $data['attachment'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $data['attachment'];
                $originalName = $file->getClientOriginalName();
                $data['attachment'] = $file->storeAs('announcements/attachments', $originalName, 'public');
            }

            $announcement = $this->repository->create($data);
            return $this->success($announcement, 'Pengumuman berhasil dibuat');
        } catch (\Exception $e) {
            return $this->error('Gagal membuat pengumuman', $e->getMessage());
        }
    }

    /**
     * Update announcement
     */
    public function update($id, array $data)
    {
        try {
            $announcement = $this->repository->find($id);
            if (!$announcement) {
                return $this->error('Pengumuman tidak ditemukan');
            }

            // Generate slug if title changed
            if (isset($data['title']) && $data['title'] !== $announcement->title) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
            }

            // Handle image upload
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                // Delete old image
                if ($announcement->image) {
                    $this->fileService->delete($announcement->image);
                }
                $data['image'] = $this->fileService->uploadAndResize($data['image'], 'announcements');
            }

            // Handle banner upload
            if (isset($data['banner']) && $data['banner'] instanceof \Illuminate\Http\UploadedFile) {
                if ($announcement->banner) {
                    $this->fileService->delete($announcement->banner);
                }
                $data['banner'] = $this->fileService->uploadAndResize($data['banner'], 'announcements', 1200, 400);
            }

            // Handle attachment upload with original name
            if (isset($data['attachment']) && $data['attachment'] instanceof \Illuminate\Http\UploadedFile) {
                // Delete old attachment
                if ($announcement->attachment) {
                    $this->fileService->delete($announcement->attachment);
                }
                $file = $data['attachment'];
                $originalName = $file->getClientOriginalName();
                $data['attachment'] = $file->storeAs('announcements/attachments', $originalName, 'public');
            }

            $announcement = $this->repository->update($id, $data);
            return $this->success($announcement, 'Pengumuman berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate pengumuman', $e->getMessage());
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
     * Get published announcements
     */
    public function getPublished($perPage = 10)
    {
        try {
            $announcements = $this->repository->getPublished($perPage);
            return $this->success($announcements);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil pengumuman', $e->getMessage());
        }
    }

    /**
     * Get all announcements with filter
     */
    public function getAll(string $search = null, $perPage = 15)
    {
        try {
            $query = $this->repository->query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            }

            $query->orderBy('created_at', 'desc');
            $announcements = $query->paginate($perPage);

            return $this->success($announcements);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil pengumuman', $e->getMessage());
        }
    }

    /**
     * Get by ID
     */
    public function getById($id)
    {
        try {
            $announcement = $this->repository->find($id);
            if ($announcement) {
                return $this->success($announcement);
            }
            return $this->error('Pengumuman tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil pengumuman', $e->getMessage());
        }
    }

    /**
     * Delete announcement
     */
    public function delete($id)
    {
        try {
            $announcement = $this->repository->find($id);
            if (!$announcement) {
                return $this->error('Pengumuman tidak ditemukan');
            }

            if ($announcement->image) {
                $this->fileService->delete($announcement->image);
            }
            if ($announcement->banner) {
                $this->fileService->delete($announcement->banner);
            }
            if ($announcement->attachment) {
                $this->fileService->delete($announcement->attachment);
            }

            $deleted = $this->repository->delete($id);
            if ($deleted) {
                return $this->success(null, 'Pengumuman berhasil dihapus');
            }
            return $this->error('Gagal menghapus pengumuman');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus pengumuman', $e->getMessage());
        }
    }
}

