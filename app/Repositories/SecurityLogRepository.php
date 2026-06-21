<?php

namespace App\Repositories;

use App\Models\SecurityLog;

class SecurityLogRepository extends BaseRepository
{
    public function __construct(SecurityLog $model)
    {
        parent::__construct($model);
    }

    /**
     * Get blocked logs
     */
    public function getBlocked($perPage = 50)
    {
        return $this->model->where('status', 'blocked')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get logs by IP
     */
    public function getByIp(string $ipAddress, $limit = 100)
    {
        return $this->model->where('ip_address', $ipAddress)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get suspicious logs
     */
    public function getSuspicious($perPage = 50)
    {
        return $this->model->where('status', 'suspicious')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}

