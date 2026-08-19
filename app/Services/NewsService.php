<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use App\Services\FileUploadService;
use Illuminate\Support\Str;

class NewsService extends BaseService
{
    public function __construct(
        private NewsRepository $repository,
        private FileUploadService $fileService
    ) {}

    /**
     * Create news
     */
    public function create(array $data)
    {
        try {
            // Generate slug if not provided or empty
            if (empty($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title']);
            } else {
                // Ensure slug is unique
                $data['slug'] = $this->generateUniqueSlug($data['slug']);
            }

            // Set published_at if status is published
            if (isset($data['status']) && $data['status'] === 'published' && !isset($data['published_at'])) {
                $data['published_at'] = \DB::raw('NOW()');
            }

            // ✅ LOGIKA BARU: Controller sudah memproses upload dan mengirim string JSON.
            // Kita hanya perlu fallback jika ada yang mengirim UploadedFile secara langsung (Legacy).
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $path = $this->fileService->uploadAndResize($data['image'], 'news', 1600, 900);
                $data['image'] = json_encode([$path]); // Bungkus dalam JSON array agar konsisten
            }
            // Jika $data['image'] sudah berupa string (JSON dari Controller), biarkan masuk ke repository.

            // Upload file if exists
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                $data['file'] = $this->fileService->upload($data['file'], 'news/files');
                $data['is_have_file'] = true;
            }

            $news = $this->repository->create($data);
            return $this->success($news, 'Berita berhasil dibuat');
        } catch (\Exception $e) {
            return $this->error('Gagal membuat berita: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Update news
     */
    public function update($id, array $data)
    {
        try {
            $news = $this->repository->find($id);
            if (!$news) {
                return $this->error('Berita tidak ditemukan');
            }

            // Handle slug: use provided slug or generate from title if changed
            if (isset($data['slug']) && !empty($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['slug'], $id);
            } elseif (isset($data['title']) && $data['title'] !== $news->title) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
            }

            // Handle is_featured checkbox
            if (!isset($data['is_featured'])) {
                $data['is_featured'] = false;
            }

            // Set published_at if status changed to published
            if (isset($data['status']) && $data['status'] === 'published' && $news->status !== 'published' && !isset($data['published_at'])) {
                $data['published_at'] = \DB::raw('NOW()');
            }

            // ✅ Handle image deletion flag (Hapus semua foto lama jika dicentang)
            if (isset($data['delete_image']) && $data['delete_image'] === true) {
                $this->deleteImagePaths($news->image);
                $data['image'] = null;
                unset($data['delete_image']);
            }

            // ✅ Handle image replacement (Jika Controller mengirim string JSON/path baru)
            if (isset($data['image']) && is_string($data['image']) && $data['image'] !== $news->image) {
                $this->deleteImagePaths($news->image); // Hapus foto-foto lama dari storage
            }

            // Fallback: Handle image upload jika ada UploadedFile (Legacy)
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $this->deleteImagePaths($news->image);
                $path = $this->fileService->uploadAndResize($data['image'], 'news', 1600, 900);
                $data['image'] = json_encode([$path]);
            }

            // Handle file deletion flag
            if (isset($data['delete_file']) && $data['delete_file'] === true) {
                if ($news->file) {
                    $this->fileService->delete($news->file);
                }
                $data['file'] = null;
                $data['is_have_file'] = false;
                unset($data['delete_file']);
            }

            // Handle file upload
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                if ($news->file) {
                    $this->fileService->delete($news->file);
                }
                $data['file'] = $this->fileService->upload($data['file'], 'news/files');
                $data['is_have_file'] = true;
            }

            // Remove delete flags before update
            unset($data['delete_image']);
            unset($data['delete_file']);

            $news = $this->repository->update($id, $data);
            return $this->success($news, 'Berita berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate berita: ' . $e->getMessage(), $e->getMessage());
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
     * Get published news
     */
    public function getPublished($perPage = 10)
    {
        try {
            $news = $this->repository->getPublished($perPage);
            return $this->success($news);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil berita', $e->getMessage());
        }
    }

    /**
     * Increment view count
     */
    public function incrementViewCount($id)
    {
        try {
            $news = $this->repository->incrementViewCount($id);
            if ($news) {
                return $this->success($news);
            }
            return $this->error('Berita tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate view count', $e->getMessage());
        }
    }

    /**
     * Get all news with filter (for admin)
     */
    public function getAll(string $search = null, string $status = 'all', int $perPage = 15, int $start = 0, string $orderBy = 'created_at', string $orderDir = 'desc')
    {
        try {
            $baseQuery = $this->repository->query()->with('category');

            if ($status !== 'all') {
                $baseQuery->where('status', $status);
            }

            if ($search) {
                $baseQuery->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('tags', 'like', "%{$search}%");
                });
            }

            $total = (clone $baseQuery)->count();

            $validOrderBy = ['id', 'title', 'category_id', 'period', 'status', 'is_featured', 'view_count', 'published_at', 'created_at'];
            if (!in_array($orderBy, $validOrderBy)) {
                $orderBy = 'created_at';
            }
            $baseQuery->orderBy($orderBy, $orderDir);

            if ($perPage > 0) {
                if ($start > 0) {
                    $baseQuery->offset($start)->limit($perPage);
                } else {
                    $baseQuery->limit($perPage);
                }
            }

            $items = $baseQuery->get();

            $currentPage = $start > 0 && $perPage > 0 ? ceil(($start / $perPage) + 1) : 1;
            $news = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $total,
                $perPage > 0 ? $perPage : ($total > 0 ? $total : 1),
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return $this->success($news);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil berita', $e->getMessage());
        }
    }

    /**
     * Get single news by ID
     */
    public function getById($id)
    {
        try {
            $news = $this->repository->find($id);
            if ($news) {
                return $this->success($news);
            }
            return $this->error('Berita tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil berita', $e->getMessage());
        }
    }

    /**
     * Delete news
     */
    public function delete($id)
    {
        try {
            $news = $this->repository->find($id);
            if (!$news) {
                return $this->error('Berita tidak ditemukan');
            }

            // ✅ Hapus semua file gambar (mendukung single path maupun JSON array)
            $this->deleteImagePaths($news->image);

            // Hapus file lampiran
            if ($news->file) {
                $this->fileService->delete($news->file);
            }

            $deleted = $this->repository->delete($id);
            if ($deleted) {
                return $this->success(null, 'Berita berhasil dihapus');
            }
            return $this->error('Gagal menghapus berita');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus berita', $e->getMessage());
        }
    }

    // ═══════════════════════════════════════════════════════
    // ✅ HELPER BARU: Menghapus file fisik (Mendukung JSON Array & String Biasa)
    // ═══════════════════════════════════════════════════════
    private function deleteImagePaths($imageValue): void
    {
        if (!$imageValue) return;

        $paths = [];
        if (is_string($imageValue)) {
            $decoded = json_decode($imageValue, true);
            // Jika valid JSON array, gunakan. Jika bukan (data lama/single path), bungkus dalam array.
            $paths = is_array($decoded) ? $decoded : [$imageValue];
        } elseif (is_array($imageValue)) {
            $paths = $imageValue;
        }

        foreach ($paths as $path) {
            if ($path) {
                $this->fileService->delete($path);
            }
        }
    }
}