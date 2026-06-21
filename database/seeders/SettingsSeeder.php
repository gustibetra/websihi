<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
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

        $this->command->info('Seeding Settings data...');

        // Create or update settings
        $setting = Setting::firstOrCreate(
            ['id' => 1],
            [
                'institution_name' => 'DPRD Kota Cimahi',
                'address' => 'Jl. Rd. Demang Hardjakusumah No. 1, Cimahi',
                'email' => 'info@dprd-cimahi.go.id',
                'phone' => '022-12345678',
                'fax' => '022-12345679',
                'website' => 'https://dprd-cimahi.go.id',
                'google_map' => '<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'logo' => null,
                'favicon' => null,
                'facebook' => 'https://facebook.com/dprdcimahi',
                'instagram' => 'https://instagram.com/dprdcimahi',
                'twitter' => 'https://twitter.com/dprdcimahi',
                'youtube' => 'https://youtube.com/dprdcimahi',
                'whatsapp' => '6281312901432',
                'vision' => 'Menjadi DPRD yang profesional, transparan, dan akuntabel dalam melaksanakan fungsi legislasi, anggaran, dan pengawasan untuk kesejahteraan masyarakat Kota Cimahi.',
                'mission' => '1. Meningkatkan kualitas legislasi yang responsif terhadap kebutuhan masyarakat
2. Melaksanakan pengawasan yang efektif terhadap eksekutif
3. Meningkatkan transparansi dan akuntabilitas dalam pengelolaan anggaran
4. Membangun komunikasi yang baik dengan masyarakat',
                'description' => 'Dewan Perwakilan Rakyat Daerah (DPRD) Kota Cimahi adalah lembaga perwakilan rakyat daerah yang berkedudukan sebagai unsur penyelenggara Pemerintahan Daerah di Kota Cimahi.',
                'active_period' => '2024-2029',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]
        );

        // Update active_period jika sudah ada
        if ($setting->wasRecentlyCreated === false) {
            $setting->update([
                'active_period' => '2024-2029',
                'updated_by' => $user->id,
            ]);
        }

        $this->command->info('Settings created/updated successfully!');
        $this->command->info('Active Period: 2024-2029');
    }
}
