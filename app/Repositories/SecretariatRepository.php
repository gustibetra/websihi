<?php

namespace App\Repositories;

use App\Models\Secretariat;

class SecretariatRepository extends BaseRepository
{
    public function __construct(Secretariat $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active secretariat
     */
    public function getActive($perPage = null)
    {
        $query = $this->model->where('is_active', true)
            ->orderBy('name', 'asc');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Get by division
     */
    public function getByDivision(string $division)
    {
        return $this->model->where('is_active', true)
            ->where('division', $division)
            ->orderBy('name', 'asc')
            ->get();
    }
}

