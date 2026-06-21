<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,       // 1. Buat user SuperAdmin
            SettingsSeeder::class,   // 2. Settings website
            CommonDataSeeder::class, // 3. Master data SMK (jurusan, kategori, fasilitas)
            TeacherSeeder::class,    // 4. Data Guru & Tendik
            SdmAndTestimonialsSeeder::class, // 5. Data Siswa, Alumni, Struktural Yayasan, & Testimoni
            HomeSectionSeeder::class, // 6. Pengaturan Halaman Beranda
            AchievementSeeder::class, // 7. Data Prestasi Siswa & Sekolah
            EventSeeder::class,       // 8. Data Agenda & Event Sekolah
            AnnouncementSeeder::class, // 9. Data Pengumuman Sekolah
            GallerySeeder::class,      // 10. Data Galeri Foto Sekolah
            DownloadSeeder::class,     // 11. Data Unduhan / Download Center
            AlumniSeeder::class,       // 12. Data Alumni Khusus (15 Data)
            TestimonialsSeeder::class, // 13. Data Testimoni Umum (15 Data)
            MitraSeeder::class,        // 14. Data Mitra Industri / DUDI (10 Data)
            OrgAndEkskulMemberSeeder::class, // 15. Data Struktur Organisasi Siswa & Ekskul
        ]);
    }
}
