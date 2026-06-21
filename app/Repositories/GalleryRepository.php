<?php

namespace App\Repositories;

use App\Models\Gallery;

class GalleryRepository extends BaseRepository
{
    public function __construct(Gallery $model)
    {
        parent::__construct($model);
    }

    public function getAll(string $search = null, int $perPage = 15, $category = null, $jurusan = null)
    {
        $query = $this->model->query()
            ->with(['user', 'coverImage', 'category', 'jurusan'])
            ->withCount('images')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($category && $category !== 'all') {
            $query->where('category_id', $category);
        }

        if ($jurusan && $jurusan !== 'all') {
            if ($jurusan === 'umum') {
                $query->whereNull('jurusan_id');
            } else {
                $query->where('jurusan_id', $jurusan);
            }
        }

        return $query->paginate($perPage);
    }

    public function getPublished(int $perPage = 16)
    {
        return $this->model->query()
            ->with(['user', 'coverImage', 'images'])
            ->withCount('images')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getBySlug(string $slug)
    {
        return $this->model->query()
            ->with(['user', 'coverImage', 'images'])
            ->withCount('images')
            ->where('slug', $slug)
            ->first();
    }
}