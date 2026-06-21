<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user (admin) as creator
        $user = User::first();

        if (!$user) {
            $this->command->warn('No user found. Please run UserSeeder first.');
            return;
        }

        $this->command->info('Seeding Common data...');

        // 1. Create Periods
        $this->createPeriods($user);

        // 2. Create Structure Types
        $this->createStructureTypes($user);

        // 3. Create Structures
        $this->createStructures($user);

        // 4. Create Categories
        $this->createCategories($user);

        $this->command->info('Common data seeded successfully!');
    }

    /**
     * Create periods
     */
    private function createPeriods($user): void
    {
        $this->command->info('Creating periods...');

        // Period 2019-2024
        Common::updateOrCreate(
            [
                'table_name' => 'period',
                'key1' => 'PD01',
            ],
            [
                'data1' => '2019-2024',
                'date1' => '2019-10-01',
                'date2' => '2024-09-30',
                'data4' => '0', // Not active
                'text1' => 'Periode DPRD 2019-2024',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]
        );

        // Period 2024-2029 (Active)
        Common::updateOrCreate(
            [
                'table_name' => 'period',
                'key1' => 'PD02',
            ],
            [
                'data1' => '2024-2029',
                'date1' => '2024-10-01',
                'date2' => '2029-09-30',
                'data4' => '1', // Active
                'text1' => 'Periode DPRD 2024-2029',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]
        );

        $this->command->info('Periods created: PD01 (2019-2024), PD02 (2024-2029)');
    }

    /**
     * Create structure types
     */
    private function createStructureTypes($user): void
    {
        $this->command->info('Creating structure types...');

        $structureTypes = [
            ['key1' => 'dapil', 'data1' => 'Dapil'],
            ['key1' => 'komisi', 'data1' => 'Komisi'],
            ['key1' => 'fraksi', 'data1' => 'Fraksi'],
            ['key1' => 'akd', 'data1' => 'AKD'],
        ];

        foreach ($structureTypes as $type) {
            Common::updateOrCreate(
                [
                    'table_name' => 'structure_type',
                    'key1' => $type['key1'],
                ],
                [
                    'data1' => $type['data1'],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }

        $this->command->info('Structure types created: dapil, komisi, fraksi, akd');
    }

    /**
     * Create structures (Dapil, Komisi, Fraksi)
     */
    private function createStructures($user): void
    {
        $this->command->info('Creating structures...');

        $period = '2024-2029';

        // Dapil Structures
        $dapils = [
            ['key1' => 'DP01', 'data1' => 'Dapil 1', 'data2' => 'KOTA CIMAHI 1 | CIMAHI UTARA A', 'data3' => '1'],
            ['key1' => 'DP02', 'data1' => 'Dapil 2', 'data2' => 'KOTA CIMAHI 2 | CIMAHI SELATAN', 'data3' => '2'],
            ['key1' => 'DP03', 'data1' => 'Dapil 3', 'data2' => 'KOTA CIMAHI 3 | CIMAHI TENGAH', 'data3' => '3'],
        ];

        foreach ($dapils as $dapil) {
            Common::updateOrCreate(
                [
                    'table_name' => 'structure',
                    'key1' => $dapil['key1'],
                ],
                [
                    'key2' => 'dapil',
                    'key3' => $period,
                    'data1' => $dapil['data1'],
                    'data2' => $dapil['data2'],
                    'data3' => $dapil['data3'],
                    'text1' => 'Daerah Pemilihan ' . $dapil['data1'],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }

        // Komisi Structures
        $komisis = [
            ['key1' => 'KM01', 'data1' => 'Komisi A', 'data2' => 'Komisi Bidang Pemerintahan', 'data3' => '1'],
            ['key1' => 'KM02', 'data1' => 'Komisi B', 'data2' => 'Komisi Bidang Perekonomian', 'data3' => '2'],
            ['key1' => 'KM03', 'data1' => 'Komisi C', 'data2' => 'Komisi Bidang Pembangunan', 'data3' => '3'],
            ['key1' => 'KM04', 'data1' => 'Komisi D', 'data2' => 'Komisi Bidang Kesejahteraan Rakyat', 'data3' => '4'],
        ];

        foreach ($komisis as $komisi) {
            Common::updateOrCreate(
                [
                    'table_name' => 'structure',
                    'key1' => $komisi['key1'],
                ],
                [
                    'key2' => 'komisi',
                    'key3' => $period,
                    'data1' => $komisi['data1'],
                    'data2' => $komisi['data2'],
                    'data3' => $komisi['data3'],
                    'text1' => $komisi['data2'],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }

        // Fraksi Structures
        $fractions = [
            ['key1' => 'FR01', 'data1' => 'Fraksi Demokrat', 'data3' => '1'],
            ['key1' => 'FR02', 'data1' => 'Fraksi PKS', 'data3' => '2'],
            ['key1' => 'FR03', 'data1' => 'Fraksi PDI-P', 'data3' => '3'],
            ['key1' => 'FR04', 'data1' => 'Fraksi PKB', 'data3' => '4'],
            ['key1' => 'FR05', 'data1' => 'Fraksi Gerindra', 'data3' => '5'],
        ];

        foreach ($fractions as $fraction) {
            Common::updateOrCreate(
                [
                    'table_name' => 'structure',
                    'key1' => $fraction['key1'],
                ],
                [
                    'key2' => 'fraksi',
                    'key3' => $period,
                    'data1' => $fraction['data1'],
                    'data2' => null,
                    'data3' => $fraction['data3'],
                    'text1' => 'Fraksi ' . $fraction['data1'],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }

        $this->command->info('Structures created: 3 Dapil, 4 Komisi, 5 Fraksi');
    }

    /**
     * Create categories
     */
    private function createCategories($user): void
    {
        $this->command->info('Creating categories...');

        // News Categories
        $newsCategories = [
            ['key1' => 'NC01', 'data1' => 'Utama'],
            ['key1' => 'NC02', 'data1' => 'Politik'],
            ['key1' => 'NC03', 'data1' => 'Ekonomi'],
            ['key1' => 'NC04', 'data1' => 'Pembangunan'],
            ['key1' => 'NC05', 'data1' => 'Kesejahteraan'],
        ];

        foreach ($newsCategories as $category) {
            Common::updateOrCreate(
                [
                    'table_name' => 'news_category',
                    'key1' => $category['key1'],
                ],
                [
                    'data1' => $category['data1'],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }

        // Event Categories
        $eventCategories = [
            ['key1' => 'EC01', 'data1' => 'Rapat'],
            ['key1' => 'EC02', 'data1' => 'Kunjungan'],
            ['key1' => 'EC03', 'data1' => 'Seminar'],
            ['key1' => 'EC04', 'data1' => 'Workshop'],
        ];

        foreach ($eventCategories as $category) {
            Common::updateOrCreate(
                [
                    'table_name' => 'event_category',
                    'key1' => $category['key1'],
                ],
                [
                    'data1' => $category['data1'],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }

        // Announcement Categories
        $announcementCategories = [
            ['key1' => 'AC01', 'data1' => 'Pengumuman Umum'],
            ['key1' => 'AC02', 'data1' => 'Pengumuman Penting'],
            ['key1' => 'AC03', 'data1' => 'Pengumuman Lelang'],
        ];

        foreach ($announcementCategories as $category) {
            Common::updateOrCreate(
                [
                    'table_name' => 'announcement_category',
                    'key1' => $category['key1'],
                ],
                [
                    'data1' => $category['data1'],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }

        $this->command->info('Categories created: 5 News, 4 Event, 3 Announcement');
    }
}
