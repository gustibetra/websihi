<?php

namespace App\Repositories;

use App\Models\SecuritySetting;

class SecuritySettingRepository extends BaseRepository
{
    public function __construct(SecuritySetting $model)
    {
        parent::__construct($model);
    }

    /**
     * Get value by key
     */
    public function getValue(string $key, $default = null)
    {
        $setting = $this->model->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set value by key
     */
    public function setValue(string $key, $value, string $description = null)
    {
        return $this->model->updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description,
            ]
        );
    }

    /**
     * Check if setting is enabled
     */
    public function isEnabled(string $key): bool
    {
        $value = $this->getValue($key, '0');
        return $value === '1' || $value === 'true' || $value === true;
    }
}

