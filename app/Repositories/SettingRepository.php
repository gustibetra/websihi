<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends BaseRepository
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /**
     * Get first setting or create if not exists
     */
    public function getFirstOrCreate()
    {
        return $this->model->firstOrCreate([], []);
    }

    /**
     * Update settings
     */
    public function updateSettings(array $data)
    {
        $setting = $this->getFirstOrCreate();
        $setting->update($data);
        return $setting;
    }
}

