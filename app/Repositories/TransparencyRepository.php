<?php

namespace App\Repositories;

use App\Models\Transparency;

class TransparencyRepository extends BaseRepository
{
    public function __construct(Transparency $model)
    {
        parent::__construct($model);
    }

    /**
     * Get public transparency records
     */
    public function getPublic($perPage = 10)
    {
        return $this->model->where('is_active', true)
            ->where('is_public', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get by type
     */
    public function getByType(string $type, $perPage = 10)
    {
        return $this->model->where('type', $type)
            ->where('is_active', true)
            ->where('is_public', true)
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get by year
     */
    public function getByYear(int $year, $perPage = 10)
    {
        return $this->model->where('year', $year)
            ->where('is_active', true)
            ->where('is_public', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}

