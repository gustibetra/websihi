<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository extends BaseRepository
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    /**
     * Find by slug (with optional filters)
     */
    public function findBySlug(string $slug, bool $activeOnly = false, bool $publicOnly = false)
    {
        $query = $this->model->where('slug', $slug);
        
        if ($activeOnly) {
            $query->where('is_active', true);
        }
        
        if ($publicOnly) {
            $query->where('is_public', true);
        }
        
        return $query->first();
    }

    /**
     * Get active pages
     */
    public function getActive($perPage = null)
    {
        $query = $this->model->where('is_active', true)
            ->where('is_public', true)
            ->orderBy('title', 'asc');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Get pages by type
     */
    public function getByType(string $type, $perPage = null)
    {
        $query = $this->model->where('page_type', $type)
            ->orderBy('created_at', 'desc');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Get pages by period
     */
    public function getByPeriod(string $period, $perPage = null)
    {
        $query = $this->model->where('period', $period)
            ->orderBy('created_at', 'desc');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }
}

