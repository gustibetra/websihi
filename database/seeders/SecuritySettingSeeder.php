<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SecuritySetting;

class SecuritySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'ip_filtering_enabled',
                'value' => '0',
                'description' => 'Enable/disable IP filtering based on geolocation (Indonesia only)',
            ],
            [
                'key' => 'user_agent_filtering_enabled',
                'value' => '1',
                'description' => 'Enable/disable user agent filtering (block Postman, cURL, etc)',
            ],
            [
                'key' => 'rate_limiting_enabled',
                'value' => '1',
                'description' => 'Enable/disable rate limiting',
            ],
            [
                'key' => 'rate_limit_per_hour',
                'value' => '100',
                'description' => 'Maximum requests per hour per IP',
            ],
            [
                'key' => 'security_logging_enabled',
                'value' => '1',
                'description' => 'Enable/disable security event logging',
            ],
        ];

        foreach ($settings as $setting) {
            SecuritySetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'description' => $setting['description'],
                ]
            );
        }

        $this->command->info('Security settings seeded successfully!');
    }
}
