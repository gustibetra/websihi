<?php

namespace App\Repositories;

use App\Models\News;

class NewsRepository extends BaseRepository
{
    public function __construct(News $model)
    {
        parent::__construct($model);
    }

    /**
     * Get published news
     */
    public function getPublished($perPage = 10)
    {
        return $this->model->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get featured news
     */
    public function getFeatured($limit = 5)
    {
        return $this->model->where('status', 'published')
            ->where('is_featured', true)
            ->where('published_at', '<=', now())
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get news by category
     */
    public function getByCategory($categoryId, $perPage = 10)
    {
        return $this->model->where('status', 'published')
            ->where('category_id', $categoryId)
            ->where('published_at', '<=', now())
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /**
     * Find by slug
     */
    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Increment view count
     */
    public function incrementViewCount($id)
    {
        $news = $this->find($id);
        if ($news) {
            $news->increment('view_count');
            return $news;
        }
        return null;
    }

    /**
     * Search news
     */
    public function search(string $keyword, $perPage = 10)
    {
        return $this->model->where('status', 'published')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%")
                    ->orWhere('tags', 'like', "%{$keyword}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }
}

