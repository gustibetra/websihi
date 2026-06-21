<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Achievement;
use App\Models\Program;
use App\Models\Common;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        // Get category IDs
        $akademik = Common::where('table_name', 'kategori_prestasi')->where('data1', 'Akademik')->first()?->id;
        $nonAkademik = Common::where('table_name', 'kategori_prestasi')->where('data1', 'Non Akademik')->first()?->id;
        $kejuruan = Common::where('table_name', 'kategori_prestasi')->where('data1', 'Kejuruan')->first()?->id;
        $olahraga = Common::where('table_name', 'kategori_prestasi')->where('data1', 'Olahraga')->first()?->id;
        $seni = Common::where('table_name', 'kategori_prestasi')->where('data1', 'Seni dan Budaya')->first()?->id;
        $literasi = Common::where('table_name', 'kategori_prestasi')->where('data1', 'Literasi')->first()?->id;

        // Get tingkat IDs
        $nasional = Common::where('table_name', 'tingkatan_prestasi')->where('data1', 'Nasional')->first()?->id;
        $provinsi = Common::where('table_name', 'tingkatan_prestasi')->where('data1', 'Provinsi')->first()?->id;
        $kabupaten = Common::where('table_name', 'tingkatan_prestasi')->where('data1', 'Kabupaten / Kota')->first()?->id;
        $sekolah = Common::where('table_name', 'tingkatan_prestasi')->where('data1', 'Antar Sekolah')->first()?->id;

        // Get programs
        $rpl = Program::where('kode', 'RPL')->first()?->id;
        $tjkt = Program::where('kode', 'TJKT')->first()?->id;
        $akl = Program::where('kode', 'AKL')->first()?->id;

        // 5 Siswa achievements
        $siswaAchievements = [
            [
                'type' => 'siswa',
                'title' => 'Juara 1 Lomba Robotik Nasional 2026',
                'achiever' => 'Ahmad Fauzi & Tim',
                'jurusan_id' => $tjkt,
                'kategori_id' => $kejuruan,
                'tingkat_id' => $nasional,
                'date' => '2026-05-15',
                'organizer' => 'Kementerian Riset dan Teknologi',
                'description' => 'Siswa TJKT berhasil meraih medali emas dalam kompetisi robotika tingkat nasional dengan inovasi robot penyelamat mandiri berbasis AI.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'type' => 'siswa',
                'title' => 'Juara 2 Olimpiade Matematika Terapan',
                'achiever' => 'Riska Amelia',
                'jurusan_id' => $akl,
                'kategori_id' => $akademik,
                'tingkat_id' => $provinsi,
                'date' => '2026-04-18',
                'organizer' => 'Universitas Indonesia',
                'description' => 'Prestasi membanggakan diraih oleh siswi Akuntansi dalam olimpiade matematika terapan tingkat provinsi Jawa Barat.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'type' => 'siswa',
                'title' => 'Juara 1 Web Design Competition 2026',
                'achiever' => 'Budi Setiawan',
                'jurusan_id' => $rpl,
                'kategori_id' => $kejuruan,
                'tingkat_id' => $nasional,
                'date' => '2026-03-22',
                'organizer' => 'Kementerian Pendidikan dan Kebudayaan',
                'description' => 'Budi Setiawan dari kelas XII RPL meraih Juara 1 nasional dalam kategori desain antarmuka web interaktif bertema edukasi pasca-pandemi.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'type' => 'siswa',
                'title' => 'Juara 1 Kejuaraan Pencak Silat Pelajar',
                'achiever' => 'Deden Kurnia',
                'jurusan_id' => null,
                'kategori_id' => $olahraga,
                'tingkat_id' => $kabupaten,
                'date' => '2026-02-10',
                'organizer' => 'IPSI Kabupaten Subang',
                'description' => 'Medali emas diraih oleh Deden Kurnia dalam kategori tanding kelas C Putra Kejuaraan Pencak Silat Pelajar se-Kabupaten Subang.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'type' => 'siswa',
                'title' => 'Juara 3 Lomba Karya Tulis Ilmiah Populer',
                'achiever' => 'Siti Nurhaliza',
                'jurusan_id' => $rpl,
                'kategori_id' => $literasi,
                'tingkat_id' => $provinsi,
                'date' => '2026-01-15',
                'organizer' => 'Dinas Pendidikan Jawa Barat',
                'description' => 'Siti Nurhaliza berhasil menyabet juara ketiga melalui karya tulis ilmiah populernya yang membahas pemanfaatan IoT untuk pertanian berkelanjutan.',
                'is_active' => true,
                'created_by' => 1,
            ],
        ];

        // 5 Sekolah achievements
        $sekolahAchievements = [
            [
                'type' => 'sekolah',
                'title' => 'Penghargaan Sekolah Adiwiyata Mandiri 2026',
                'achiever' => 'SMK PGRI Subang',
                'jurusan_id' => null,
                'kategori_id' => $nonAkademik,
                'tingkat_id' => $nasional,
                'date' => '2026-06-05',
                'organizer' => 'Kementerian Lingkungan Hidup dan Kehutanan',
                'description' => 'SMK PGRI Subang dianugerahi penghargaan Adiwiyata Mandiri atas konsistensi sekolah dalam menerapkan budaya peduli lingkungan hidup dan kelestarian alam.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'type' => 'sekolah',
                'title' => 'Sekolah Rujukan Pembelajaran Berbasis Industri',
                'achiever' => 'SMK PGRI Subang',
                'jurusan_id' => null,
                'kategori_id' => $kejuruan,
                'tingkat_id' => $nasional,
                'date' => '2026-05-20',
                'organizer' => 'Direktorat PSMK Kemendikbud',
                'description' => 'Terpilih menjadi salah satu sekolah percontohan nasional dalam mengimplementasikan kurikulum link and match kelas industri bersama mitra multinasional.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'type' => 'sekolah',
                'title' => 'Juara 1 Perpustakaan Sekolah Terbaik',
                'achiever' => 'Perpustakaan Widya Pustaka',
                'kategori_id' => $literasi,
                'tingkat_id' => $kabupaten,
                'date' => '2026-04-12',
                'organizer' => 'Dinas Kearsipan dan Perpustakaan Daerah',
                'description' => 'Perpustakaan Widya Pustaka SMK PGRI Subang dinobatkan sebagai perpustakaan sekolah dengan pengelolaan digital dan kenyamanan baca terbaik tingkat kabupaten.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'type' => 'sekolah',
                'title' => 'Penghargaan Apresiasi Seni & Budaya Daerah',
                'achiever' => 'Grup Seni Lingkar Widya',
                'kategori_id' => $seni,
                'tingkat_id' => $provinsi,
                'date' => '2026-03-10',
                'organizer' => 'Dinas Pariwisata dan Kebudayaan Jabar',
                'description' => 'Apresiasi tinggi diberikan atas dedikasi sekolah dalam melestarikan seni musik tradisional kecapi suling dan angklung interaktif di kalangan remaja.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'type' => 'sekolah',
                'title' => 'Juara Umum Tata Kelola Sanitasi Sekolah Sehat',
                'achiever' => 'SMK PGRI Subang',
                'kategori_id' => $nonAkademik,
                'tingkat_id' => $kabupaten,
                'date' => '2026-02-18',
                'organizer' => 'Dinas Kesehatan Kabupaten Subang',
                'description' => 'Keberhasilan mewujudkan lingkungan sekolah bersih dengan standar pengelolaan air bersih dan sanitasi kelas satu se-kabupaten Subang.',
                'is_active' => true,
                'created_by' => 1,
            ],
        ];

        // Truncate existing achievements to avoid duplicate entries when re-seeding
        DB::table('achievements')->truncate();

        foreach (array_merge($siswaAchievements, $sekolahAchievements) as $ach) {
            Achievement::create($ach);
        }
    }
}
