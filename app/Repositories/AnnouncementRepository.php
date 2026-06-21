<?php

namespace App\Repositories;

use App\Models\Announcement;

class AnnouncementRepository extends BaseRepository
{
    public function __construct(Announcement $model)
    {
        parent::__construct($model);
    }

    /**
     * Get published announcements
     */
    public function getPublished($perPage = 10)
    {
        return $this->model->where('is_active', true)
            ->where('is_public', true)
            ->where('start_date', '<=', now())
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderBy('start_date', 'desc')
            ->paginate($perPage);
    }

    /**
     * Find by slug
     */
    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}

