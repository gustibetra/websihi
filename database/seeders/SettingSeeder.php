<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if settings already exists
        $exists = DB::table('settings')->count();
        
        if ($exists === 0) {
            DB::table('settings')->insert([
                'institution_name' => 'DPRD Kabupaten/Kota',
                'address' => 'Jl. Contoh No. 123, Kota, Provinsi',
                'email' => 'info@dprd.go.id',
                'phone' => '021-12345678',
                'fax' => '021-12345679',
                'website' => 'https://dprd.go.id',
                'google_map' => null,
                'logo' => null,
                'favicon' => null,
                'facebook' => 'https://facebook.com/dprd',
                'instagram' => 'https://instagram.com/dprd',
                'twitter' => 'https://twitter.com/dprd',
                'youtube' => 'https://youtube.com/dprd',
                'whatsapp' => '628123456789',
                'vision' => 'Menjadi lembaga legislatif yang profesional, berintegritas, dan responsif terhadap aspirasi masyarakat',
                'mission' => 'Melaksanakan fungsi legislasi, anggaran, dan pengawasan dengan penuh tanggung jawab untuk kesejahteraan masyarakat',
                'description' => 'Dewan Perwakilan Rakyat Daerah adalah lembaga perwakilan rakyat daerah yang berkedudukan sebagai unsur penyelenggara pemerintahan daerah',
                'active_period' => '2024-2029',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->command->info('Settings seeded successfully!');
        } else {
            $this->command->info('Settings already exists, skipping...');
        }
    }
}
