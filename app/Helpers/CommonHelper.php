<?php

namespace App\Helpers;

use App\Services\CommonService;
use Illuminate\Support\Collection;

class CommonHelper
{
    public static function getCategories(): Collection
    {
        $service = app(CommonService::class);
        $result = $service->getByTableName('kategori_berita');
        return $result['success'] ? $result['data'] : collect([]);
    }

    /**
     * Get periods from common table
     */
    public static function getPeriods(): Collection
    {
        $service = app(CommonService::class);
        $result = $service->getByTableName('period');
        return $result['success'] ? $result['data'] : collect([]);
    }

    /**
     * Get data by table name (generic)
     */
    public static function getByTableName(string $tableName): Collection
    {
        $service = app(CommonService::class);
        $result = $service->getByTableName($tableName);
        return $result['success'] ? $result['data'] : collect([]);
    }
}

