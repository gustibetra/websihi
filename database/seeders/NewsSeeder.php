<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
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

        $this->command->info('Seeding News data...');

        // Get category
        $categoryUtama = Common::where('table_name', 'news_category')
            ->where('key1', 'NC01')
            ->first();

        $categoryPolitik = Common::where('table_name', 'news_category')
            ->where('key1', 'NC02')
            ->first();

        $period = '2024-2029';

        $newsItems = [
            [
                'title' => 'DPRD Kota Cimahi Resmi Dilantik untuk Periode 2024-2029',
                'slug' => Str::slug('DPRD Kota Cimahi Resmi Dilantik untuk Periode 2024-2029'),
                'content' => '<p>DPRD Kota Cimahi telah resmi dilantik untuk periode 2024-2029. Pelantikan ini menandai dimulainya periode baru dalam penyelenggaraan pemerintahan daerah di Kota Cimahi.</p><p>Dalam pelantikan tersebut, anggota DPRD yang terpilih mengucapkan sumpah jabatan dan berkomitmen untuk melaksanakan tugas dengan sebaik-baiknya untuk kepentingan masyarakat Kota Cimahi.</p>',
                'excerpt' => 'DPRD Kota Cimahi telah resmi dilantik untuk periode 2024-2029. Pelantikan ini menandai dimulainya periode baru dalam penyelenggaraan pemerintahan daerah.',
                'author' => 'Redaksi DPRD',
                'category_id' => $categoryUtama ? $categoryUtama->id : null,
                'period' => $period,
                'published_at' => now()->subDays(30),
                'status' => 'published',
                'tags' => 'utama,peresmian,periode-2024-2029',
                'view_count' => 1250,
                'share_count' => 45,
                'is_featured' => true,
                'source' => 'DPRD Kota Cimahi',
                'meta_title' => 'DPRD Kota Cimahi Resmi Dilantik untuk Periode 2024-2029',
                'meta_description' => 'DPRD Kota Cimahi telah resmi dilantik untuk periode 2024-2029. Pelantikan ini menandai dimulainya periode baru dalam penyelenggaraan pemerintahan daerah.',
                'is_have_file' => false,
            ],
            [
                'title' => 'Rapat Paripurna DPRD Kota Cimahi Membahas RAPBD 2025',
                'slug' => Str::slug('Rapat Paripurna DPRD Kota Cimahi Membahas RAPBD 2025'),
                'content' => '<p>DPRD Kota Cimahi menggelar rapat paripurna untuk membahas Rancangan Anggaran Pendapatan dan Belanja Daerah (RAPBD) Tahun 2025.</p><p>Dalam rapat tersebut, anggota DPRD melakukan pembahasan mendalam terkait alokasi anggaran untuk berbagai program pembangunan di Kota Cimahi.</p>',
                'excerpt' => 'DPRD Kota Cimahi menggelar rapat paripurna untuk membahas Rancangan Anggaran Pendapatan dan Belanja Daerah (RAPBD) Tahun 2025.',
                'author' => 'Redaksi DPRD',
                'category_id' => $categoryPolitik ? $categoryPolitik->id : null,
                'period' => $period,
                'published_at' => now()->subDays(20),
                'status' => 'published',
                'tags' => 'politik,rapbd,anggaran',
                'view_count' => 890,
                'share_count' => 32,
                'is_featured' => false,
                'source' => 'DPRD Kota Cimahi',
                'meta_title' => 'Rapat Paripurna DPRD Kota Cimahi Membahas RAPBD 2025',
                'meta_description' => 'DPRD Kota Cimahi menggelar rapat paripurna untuk membahas Rancangan Anggaran Pendapatan dan Belanja Daerah (RAPBD) Tahun 2025.',
                'is_have_file' => false,
            ],
            [
                'title' => 'Komisi A DPRD Kota Cimahi Lakukan Kunjungan Kerja',
                'slug' => Str::slug('Komisi A DPRD Kota Cimahi Lakukan Kunjungan Kerja'),
                'content' => '<p>Komisi A DPRD Kota Cimahi melakukan kunjungan kerja ke berbagai instansi pemerintah daerah untuk melihat langsung pelaksanaan program pembangunan.</p><p>Kunjungan kerja ini dilakukan dalam rangka meningkatkan pemahaman anggota DPRD terhadap kondisi riil di lapangan.</p>',
                'excerpt' => 'Komisi A DPRD Kota Cimahi melakukan kunjungan kerja ke berbagai instansi pemerintah daerah untuk melihat langsung pelaksanaan program pembangunan.',
                'author' => 'Redaksi DPRD',
                'category_id' => $categoryUtama ? $categoryUtama->id : null,
                'period' => $period,
                'published_at' => now()->subDays(15),
                'status' => 'published',
                'tags' => 'komisi-a,kunjungan-kerja',
                'view_count' => 650,
                'share_count' => 28,
                'is_featured' => false,
                'source' => 'DPRD Kota Cimahi',
                'meta_title' => 'Komisi A DPRD Kota Cimahi Lakukan Kunjungan Kerja',
                'meta_description' => 'Komisi A DPRD Kota Cimahi melakukan kunjungan kerja ke berbagai instansi pemerintah daerah untuk melihat langsung pelaksanaan program pembangunan.',
                'is_have_file' => false,
            ],
            [
                'title' => 'DPRD Kota Cimahi Terima Kunjungan dari DPRD Kabupaten Bandung',
                'slug' => Str::slug('DPRD Kota Cimahi Terima Kunjungan dari DPRD Kabupaten Bandung'),
                'content' => '<p>DPRD Kota Cimahi menerima kunjungan dari DPRD Kabupaten Bandung dalam rangka silaturahmi dan pertukaran informasi terkait best practices dalam penyelenggaraan pemerintahan daerah.</p>',
                'excerpt' => 'DPRD Kota Cimahi menerima kunjungan dari DPRD Kabupaten Bandung dalam rangka silaturahmi dan pertukaran informasi.',
                'author' => 'Redaksi DPRD',
                'category_id' => $categoryUtama ? $categoryUtama->id : null,
                'period' => null, // Berita umum, tidak terikat period
                'published_at' => now()->subDays(10),
                'status' => 'published',
                'tags' => 'kunjungan,silaturahmi',
                'view_count' => 420,
                'share_count' => 15,
                'is_featured' => false,
                'source' => 'DPRD Kota Cimahi',
                'meta_title' => 'DPRD Kota Cimahi Terima Kunjungan dari DPRD Kabupaten Bandung',
                'meta_description' => 'DPRD Kota Cimahi menerima kunjungan dari DPRD Kabupaten Bandung dalam rangka silaturahmi dan pertukaran informasi.',
                'is_have_file' => false,
            ],
            [
                'title' => 'Workshop Peningkatan Kapasitas Anggota DPRD Kota Cimahi',
                'slug' => Str::slug('Workshop Peningkatan Kapasitas Anggota DPRD Kota Cimahi'),
                'content' => '<p>DPRD Kota Cimahi menyelenggarakan workshop peningkatan kapasitas anggota DPRD dalam rangka meningkatkan pemahaman dan kemampuan anggota dalam melaksanakan fungsi legislasi, anggaran, dan pengawasan.</p>',
                'excerpt' => 'DPRD Kota Cimahi menyelenggarakan workshop peningkatan kapasitas anggota DPRD dalam rangka meningkatkan pemahaman dan kemampuan anggota.',
                'author' => 'Redaksi DPRD',
                'category_id' => $categoryUtama ? $categoryUtama->id : null,
                'period' => $period,
                'published_at' => now()->subDays(5),
                'status' => 'published',
                'tags' => 'workshop,kapasitas',
                'view_count' => 320,
                'share_count' => 12,
                'is_featured' => false,
                'source' => 'DPRD Kota Cimahi',
                'meta_title' => 'Workshop Peningkatan Kapasitas Anggota DPRD Kota Cimahi',
                'meta_description' => 'DPRD Kota Cimahi menyelenggarakan workshop peningkatan kapasitas anggota DPRD dalam rangka meningkatkan pemahaman dan kemampuan anggota.',
                'is_have_file' => false,
            ],
        ];

        foreach ($newsItems as $newsData) {
            News::updateOrCreate(
                ['slug' => $newsData['slug']],
                array_merge($newsData, [
                    'created_by' => $user->id,
                ])
            );
        }

        $this->command->info('News created: ' . count($newsItems) . ' news items');
    }
}
