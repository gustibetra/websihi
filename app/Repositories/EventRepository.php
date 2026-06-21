<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository extends BaseRepository
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    /**
     * Get upcoming events
     */
    public function getUpcoming($limit = 10)
    {
        return $this->model->where('is_active', true)
            ->where('is_public', true)
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime', 'asc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get past events
     */
    public function getPast($perPage = 10)
    {
        return $this->model->where('is_active', true)
            ->where('is_public', true)
            ->where('end_datetime', '<', now())
            ->orderBy('end_datetime', 'desc')
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

