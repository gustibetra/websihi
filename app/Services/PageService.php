<?php

namespace App\Services;

use App\Repositories\PageRepository;
use App\Services\FileUploadService;
use Illuminate\Support\Str;

class PageService extends BaseService
{
    public function __construct(
        private PageRepository $repository,
        private FileUploadService $fileService
    ) {}

    /**
     * Create page
     */
    public function create(array $data)
    {
        try {
            // Generate slug if not provided
            if (!isset($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title']);
            }

            // Upload image if exists
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $this->fileService->uploadAndResize($data['image'], 'pages');
            }

            // Upload attachment if exists
            if (isset($data['attachment']) && $data['attachment'] instanceof \Illuminate\Http\UploadedFile) {
                $data['attachment'] = $this->fileService->upload($data['attachment'], 'pages/attachments');
            }

            $page = $this->repository->create($data);
            return $this->success($page, 'Halaman berhasil dibuat');
        } catch (\Exception $e) {
            return $this->error('Gagal membuat halaman', $e->getMessage());
        }
    }

    /**
     * Update page
     */
    public function update($id, array $data)
    {
        try {
            $page = $this->repository->find($id);
            if (!$page) {
                return $this->error('Halaman tidak ditemukan');
            }

            // Generate slug if title changed
            if (isset($data['title']) && $data['title'] !== $page->title && !isset($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
            }

            // Handle image upload
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if ($page->image) {
                    $this->fileService->delete($page->image);
                }
                $data['image'] = $this->fileService->uploadAndResize($data['image'], 'pages');
            }

            // Handle attachment upload
            if (isset($data['attachment']) && $data['attachment'] instanceof \Illuminate\Http\UploadedFile) {
                if ($page->attachment) {
                    $this->fileService->delete($page->attachment);
                }
                $data['attachment'] = $this->fileService->upload($data['attachment'], 'pages/attachments');
            }

            $page = $this->repository->update($id, $data);
            return $this->success($page, 'Halaman berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate halaman', $e->getMessage());
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
     * Get all pages with filter
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

            $query->orderBy('title', 'asc');
            $pages = $query->paginate($perPage);

            return $this->success($pages);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil halaman', $e->getMessage());
        }
    }

    /**
     * Get by ID
     */
    public function getById($id)
    {
        try {
            $page = $this->repository->find($id);
            if ($page) {
                return $this->success($page);
            }
            return $this->error('Halaman tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil halaman', $e->getMessage());
        }
    }

    /**
     * Delete page
     */
    public function delete($id)
    {
        try {
            $page = $this->repository->find($id);
            if (!$page) {
                return $this->error('Halaman tidak ditemukan');
            }

            // Delete all files
            if ($page->image) {
                $this->fileService->delete($page->image);
            }
            if ($page->attachment) {
                $this->fileService->delete($page->attachment);
            }

            $deleted = $this->repository->delete($id);
            if ($deleted) {
                return $this->success(null, 'Halaman berhasil dihapus');
            }
            return $this->error('Gagal menghapus halaman');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus halaman', $e->getMessage());
        }
    }

    /**
     * Find by slug
     */
    public function findBySlug(string $slug, bool $activeOnly = false, bool $publicOnly = false)
    {
        try {
            $page = $this->repository->findBySlug($slug, $activeOnly, $publicOnly);
            if ($page) {
                return $this->success($page);
            }
            return $this->error('Halaman tidak ditemukan', null, false);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil halaman', $e->getMessage(), false);
        }
    }
}

