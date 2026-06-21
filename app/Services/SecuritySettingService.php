<?php

namespace App\Services;

use App\Models\SecuritySetting;

class SecuritySettingService extends BaseService
{
    /**
     * Get all security settings
     */
    public function getAll()
    {
        try {
            $settings = SecuritySetting::all()->pluck('value', 'key')->toArray();
            
            // Set defaults if not exists
            $defaults = [
                'ip_filtering_enabled' => '0',
                'user_agent_filtering_enabled' => '1',
                'rate_limiting_enabled' => '1',
                'rate_limit_per_hour' => '100',
                'security_logging_enabled' => '1',
                'disable_devtools' => '0',
            ];
            
            $settings = array_merge($defaults, $settings);
            
            return $this->success($settings);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil security settings', $e->getMessage());
        }
    }
    
    /**
     * Update security setting
     */
    public function updateSetting(string $key, $value, string $description = null)
    {
        try {
            SecuritySetting::setValue($key, $value, $description);
            return $this->success(null, 'Security setting berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate security setting', $e->getMessage());
        }
    }
    
    /**
     * Get setting value
     */
    public function getSetting(string $key, $default = null)
    {
        try {
            $value = SecuritySetting::getValue($key, $default);
            return $this->success($value);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil security setting', $e->getMessage());
        }
    }
    
    /**
     * Check if a security setting is enabled
     */
    public function isEnabled(string $key): bool
    {
        $value = SecuritySetting::getValue($key, '0');
        return $value === '1' || $value === 1 || $value === true;
    }
}
