<?php

namespace App\Helpers;

use App\Repositories\SettingRepository;

class PeriodHelper
{
    /**
     * Get active period from settings
     * 
     * @return string|null Active period (contoh: "2024-2029") atau null jika belum diset
     */
    public static function getActivePeriod(): ?string
    {
        static $activePeriod = null;

        if ($activePeriod === null) {
            $settingRepository = app(SettingRepository::class);
            $setting = $settingRepository->getFirstOrCreate();
            $activePeriod = $setting->active_period;
        }

        return $activePeriod;
    }

    /**
     * Check if period is active
     * 
     * @param string $period Period to check
     * @return bool
     */
    public static function isActivePeriod(string $period): bool
    {
        return self::getActivePeriod() === $period;
    }

    /**
     * Get all periods from common table
     * 
     * @return array List of periods
     */
    public static function getAllPeriods(): array
    {
        $commonRepository = app(\App\Repositories\CommonRepository::class);
        $periods = $commonRepository->getByTableName('period');
        
        return $periods->map(function($period) {
            return [
                'id' => $period->id,
                'key1' => $period->key1, // Period ID (PD01, PD02, dll)
                'name' => $period->data1 ?? $period->key1, // Period name (2024-2029)
                'start_date' => $period->date1 ?? null, // Using date1 column
                'end_date' => $period->date2 ?? null, // Using date2 column
                'is_active' => $period->data4 == '1',
            ];
        })->toArray();
    }
}

