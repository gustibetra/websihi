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

            // Upload image if exists
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $this->fileService->uploadAndResize($data['image'], 'news', 1600, 900);
            }

            // Upload file if exists
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                $data['file'] = $this->fileService->upload($data['file'], 'news/files');
                $data['is_have_file'] = true;
            }

            $news = $this->repository->create($data);
            return $this->success($news, 'Berita berhasil dibuat');
        } catch (\Exception $e) {
            return $this->error('Gagal membuat berita', $e->getMessage());
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
                // User provided slug, ensure it's unique
                $data['slug'] = $this->generateUniqueSlug($data['slug'], $id);
            } elseif (isset($data['title']) && $data['title'] !== $news->title) {
                // Title changed, generate new slug
                $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
            }

            // Handle is_featured checkbox (if not checked, it won't be in request)
            if (!isset($data['is_featured'])) {
                $data['is_featured'] = false;
            }

            // Set published_at if status changed to published
            if (isset($data['status']) && $data['status'] === 'published' && $news->status !== 'published' && !isset($data['published_at'])) {
                $data['published_at'] = \DB::raw('NOW()');
            }

            // Handle image deletion flag
            if (isset($data['delete_image']) && $data['delete_image'] === true) {
                if ($news->image) {
                    $this->fileService->delete($news->image);
                }
                $data['image'] = null;
                unset($data['delete_image']);
            }

            // Handle image upload
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if ($news->image) {
                    $this->fileService->delete($news->image);
                }
                $data['image'] = $this->fileService->uploadAndResize($data['image'], 'news', 1600, 900);
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

            // Remove delete flags before update (they are not database columns)
            unset($data['delete_image']);
            unset($data['delete_file']);

            $news = $this->repository->update($id, $data);
            return $this->success($news, 'Berita berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate berita', $e->getMessage());
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
     * 
     * @param string|null $search Search keyword
     * @param string $status Filter by status
     * @param int $perPage Items per page (0 for all)
     * @param int $start Offset for pagination
     * @param string $orderBy Column to order by
     * @param string $orderDir Order direction (asc/desc)
     * @return array
     */
    public function getAll(string $search = null, string $status = 'all', int $perPage = 15, int $start = 0, string $orderBy = 'created_at', string $orderDir = 'desc')
    {
        try {
            $baseQuery = $this->repository->query()->with('category');

            // Filter by status
            if ($status !== 'all') {
                $baseQuery->where('status', $status);
            }

            // Search
            if ($search) {
                $baseQuery->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('tags', 'like', "%{$search}%");
                });
            }

            // Calculate total filtered records (before ordering and pagination)
            $total = (clone $baseQuery)->count();

            // Order by
            $validOrderBy = ['id', 'title', 'category_id', 'period', 'status', 'is_featured', 'view_count', 'published_at', 'created_at'];
            if (!in_array($orderBy, $validOrderBy)) {
                $orderBy = 'created_at';
            }
            $baseQuery->orderBy($orderBy, $orderDir);

            // Apply pagination
            if ($perPage > 0) {
                if ($start > 0) {
                    $baseQuery->offset($start)->limit($perPage);
                } else {
                    $baseQuery->limit($perPage);
                }
            }

            // Get data
            $items = $baseQuery->get();

            // Create paginator for consistency
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

            // Delete associated files
            if ($news->image) {
                $this->fileService->delete($news->image);
            }
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
}

