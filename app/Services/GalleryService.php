<?php

namespace App\Services;

use App\Models\GalleryImage;
use App\Repositories\GalleryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GalleryService extends BaseService
{
    public function __construct(
        private GalleryRepository $repository,
        private FileUploadService $fileService
    ) {}

    public function getAll(string $search = null, int $perPage = 15, $category = null, $jurusan = null)
    {
        try {
            return $this->success($this->repository->getAll($search, $perPage, $category, $jurusan));
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil gallery', $e->getMessage());
        }
    }

    public function getPublished(int $perPage = 16)
    {
        try {
            return $this->success($this->repository->getPublished($perPage));
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil gallery', $e->getMessage());
        }
    }

    public function getBySlug(string $slug)
    {
        try {
            $gallery = $this->repository->getBySlug($slug);

            return $gallery
                ? $this->success($gallery)
                : $this->error('Gallery tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil gallery', $e->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            $gallery = $this->repository->query()
                ->with(['user', 'images'])
                ->withCount('images')
                ->find($id);

            return $gallery
                ? $this->success($gallery)
                : $this->error('Gallery tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil gallery', $e->getMessage());
        }
    }

    public function create(array $data)
    {
        $uploadedPaths = [];

        try {
            if (empty($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title']);
            } else {
                $data['slug'] = $this->generateUniqueSlug($data['slug']);
            }

            $images = $data['images'] ?? [];
            unset($data['images']);

            DB::beginTransaction();

            $gallery = $this->repository->create($data);

            foreach ($images as $index => $image) {
                if (!$image instanceof \Illuminate\Http\UploadedFile) {
                    continue;
                }

                $path = $this->fileService->uploadAndResize($image, 'gallery', 1600, 1600);
                $uploadedPaths[] = $path;

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }

            DB::commit();

            return $this->success($gallery->fresh(['user', 'images']), 'Gallery berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();

            foreach ($uploadedPaths as $path) {
                $this->fileService->delete($path);
            }

            return $this->error('Gagal membuat gallery', $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        $uploadedPaths = [];

        try {
            $gallery = $this->repository->query()->with('images')->find($id);

            if (!$gallery) {
                return $this->error('Gallery tidak ditemukan');
            }

            if (empty($data['slug'])) {
                if (!isset($data['title']) || $data['title'] !== $gallery->title) {
                    $data['slug'] = $this->generateUniqueSlug($data['title'] ?? $gallery->title, $id);
                }
            } else {
                $data['slug'] = $this->generateUniqueSlug($data['slug'], $id);
            }

            $images = $data['images'] ?? [];
            unset($data['images']);

            DB::beginTransaction();

            $gallery = $this->repository->update($id, $data);

            $nextSortOrder = (int) ($gallery->images()->max('sort_order') ?? -1) + 1;

            foreach ($images as $image) {
                if (!$image instanceof \Illuminate\Http\UploadedFile) {
                    continue;
                }

                $path = $this->fileService->uploadAndResize($image, 'gallery', 1600, 1600);
                $uploadedPaths[] = $path;

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $path,
                    'sort_order' => $nextSortOrder,
                ]);

                $nextSortOrder++;
            }

            DB::commit();

            return $this->success($gallery->fresh(['user', 'images']), 'Gallery berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();

            foreach ($uploadedPaths as $path) {
                $this->fileService->delete($path);
            }

            return $this->error('Gagal mengupdate gallery', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $gallery = $this->repository->query()->with('images')->find($id);

            if (!$gallery) {
                return $this->error('Gallery tidak ditemukan');
            }

            foreach ($gallery->images as $image) {
                $this->fileService->delete($image->image_path);
            }

            $deleted = $this->repository->delete($id);

            return $deleted
                ? $this->success(null, 'Gallery berhasil dihapus')
                : $this->error('Gagal menghapus gallery');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus gallery', $e->getMessage());
        }
    }

    public function deleteImage($imageId)
    {
        try {
            $image = GalleryImage::with('gallery')->find($imageId);

            if (!$image) {
                return $this->error('Gambar tidak ditemukan');
            }

            $this->fileService->delete($image->image_path);
            $image->delete();

            return $this->success(null, 'Gambar berhasil dihapus');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus gambar', $e->getMessage());
        }
    }

    private function generateUniqueSlug(string $value, $excludeId = null): string
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = $this->repository->query()->where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}