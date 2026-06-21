<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\Event;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user as creator
        $user = User::first();

        if (!$user) {
            $this->command->warn('No user found. Please run UserSeeder first.');
            return;
        }

        $this->command->info('Seeding Event/Agenda data...');

        // Get event categories from common (table_name = 'kategori_event')
        $categories = Common::where('table_name', 'kategori_event')->get()->keyBy('data1');
        
        // Fallback IDs if they aren't seeded yet
        $getCategoryId = function ($name) use ($categories) {
            return isset($categories[$name]) ? $categories[$name]->id : null;
        };

        // Get programs/jurusans
        $programs = Program::get()->keyBy('kode');
        $getRplId = isset($programs['RPL']) ? $programs['RPL']->id : null;
        $getTjktId = isset($programs['TJKT']) ? $programs['TJKT']->id : null;
        $getAklId = isset($programs['AKL']) ? $programs['AKL']->id : null;

        // Current active period
        $activePeriod = Common::where('table_name', 'period')
            ->where('data4', '1') // Active
            ->first()?->data1 ?? '2024-2029';

        $now = Carbon::now();

        $events = [
            [
                'title' => 'Seminar Tren Teknologi Industri Kreatif dan Artificial Intelligence',
                'description' => '<p>Perkembangan teknologi AI yang sangat pesat memberikan dampak besar bagi industri kreatif dan teknologi informasi. Seminar ini akan membahas tren terbaru kecerdasan buatan dan bagaimana siswa dapat mempersiapkan diri menghadapi era otomatisasi.</p><p>Acara ini wajib diikuti oleh seluruh siswa program keahlian teknologi informasi, namun terbuka juga untuk umum.</p>',
                'excerpt' => 'Seminar nasional tentang perkembangan teknologi kecerdasan buatan (AI) di dunia industri kreatif modern.',
                'location' => 'Aula Utama Lantai 3 Gedung Rektorat',
                'start_datetime' => $now->copy()->setTime(9, 0, 0),
                'end_datetime' => $now->copy()->setTime(12, 30, 0),
                'speaker' => 'Dr. Eko Prasetyo, M.T. (AI Research Lead)',
                'organizer' => 'Program Studi RPL & OSIS SMK',
                'category_id' => $getCategoryId('Seminar'),
                'jurusan_id' => $getRplId,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Workshop Web Development Modern dengan Laravel 11',
                'description' => '<p>Pelajari cara membangun aplikasi web modern menggunakan Laravel 11 dari awal hingga deployment. Workshop ini fokus pada hands-on coding, best practices, dan optimasi arsitektur web modern.</p><p>Siswa diharapkan membawa laptop masing-masing dengan PHP >= 8.2 dan Composer sudah terinstall.</p>',
                'excerpt' => 'Workshop coding praktis membangun aplikasi web interaktif menggunakan framework terpopuler Laravel 11.',
                'location' => 'Laboratorium Komputer RPL 1',
                'start_datetime' => $now->copy()->addDays(2)->setTime(8, 0, 0),
                'end_datetime' => $now->copy()->addDays(2)->setTime(16, 0, 0),
                'speaker' => 'Indra Permana (Senior Backend Developer)',
                'organizer' => 'Himpunan Jurusan RPL',
                'category_id' => $getCategoryId('Workshop'),
                'jurusan_id' => $getRplId,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Lomba Coding Antar Kelas: Web Design Competition 2026',
                'description' => '<p>Tunjukkan kreativitas dan kemampuan coding kamu dalam mendesain halaman web interaktif dengan tema "Green School Portal". Kompetisi ini ditujukan untuk memupuk semangat inovasi dan kerja sama tim.</p><p>Pemenang akan mendapatkan sertifikat penghargaan dan hadiah menarik dari sponsor industri.</p>',
                'excerpt' => 'Kompetisi desain web interaktif antar kelas dengan tema portal sekolah ramah lingkungan.',
                'location' => 'Laboratorium Komputer RPL 2',
                'start_datetime' => $now->copy()->addDays(5)->setTime(8, 30, 0),
                'end_datetime' => $now->copy()->addDays(5)->setTime(15, 0, 0),
                'speaker' => 'Team Juri Industri & Guru Produktif',
                'organizer' => 'Panitia Lomba Kominfo OSIS',
                'category_id' => $getCategoryId('Lomba / Kompetisi'),
                'jurusan_id' => $getRplId,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Pelatihan Dasar Jaringan Komputer dan Fiber Optic',
                'description' => '<p>Pelatihan teknis mengenai konfigurasi jaringan lokal (LAN), manajemen bandwidth, serta teknik instalasi dan splicing kabel fiber optic.</p><p>Sangat cocok untuk siswa yang ingin berkarir sebagai network engineer.</p>',
                'excerpt' => 'Pelatihan hands-on instalasi fiber optic and konfigurasi routing mikrotik untuk siswa TJKT.',
                'location' => 'Laboratorium Jaringan Komputer & FO',
                'start_datetime' => $now->copy()->addDays(10)->setTime(9, 0, 0),
                'end_datetime' => $now->copy()->addDays(10)->setTime(14, 0, 0),
                'speaker' => 'Irwan Setiawan, CCNA (Network Engineer)',
                'organizer' => 'Program Keahlian TJKT',
                'category_id' => $getCategoryId('Pelatihan'),
                'jurusan_id' => $getTjktId,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Kunjungan Industri ke Kantor Google Indonesia & Tokopedia',
                'description' => '<p>Kunjungan tahunan dalam rangka memperkenalkan budaya kerja perusahaan teknologi papan atas dunia (Tech Giant) kepada para siswa tingkat akhir.</p><p>Siswa akan diajak berkeliling kantor dan berdiskusi langsung dengan software engineer profesional.</p>',
                'excerpt' => 'Studi banding lapangan ke Google Indonesia dan Tokopedia Tower Jakarta untuk pengenalan budaya kerja startup.',
                'location' => 'Tech Offices Jakarta (Google & Tokopedia)',
                'start_datetime' => $now->copy()->addDays(14)->setTime(6, 0, 0),
                'end_datetime' => $now->copy()->addDays(14)->setTime(18, 0, 0),
                'speaker' => 'Developer Relations Team',
                'organizer' => 'Hubungan Industri & Humas Sekolah',
                'category_id' => $getCategoryId('Kunjungan Industri'),
                'jurusan_id' => null, // Umum
                'period' => $activePeriod,
            ],
            [
                'title' => 'Pameran Karya Kreatif Siswa SMK Unggulan 2026',
                'description' => '<p>Pameran tahunan yang memamerkan produk-produk inovatif, sistem IoT, aplikasi mobile, hingga karya seni buatan siswa-siswi berprestasi dari seluruh program keahlian.</p><p>Terbuka untuk orang tua siswa, alumni, dan perwakilan dari industri mitra.</p>',
                'excerpt' => 'Expo tahunan pameran produk inovasi, aplikasi mobile, dan teknologi tepat guna ciptaan siswa.',
                'location' => 'Lapangan Utama & Gedung Olahraga Sekolah',
                'start_datetime' => $now->copy()->subDays(5)->setTime(8, 0, 0),
                'end_datetime' => $now->copy()->subDays(5)->setTime(16, 0, 0),
                'speaker' => 'Kepala Dinas Pendidikan & Perwakilan DUDI',
                'organizer' => 'Panitia Expo SMK',
                'category_id' => $getCategoryId('Pameran'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Seminar Karier: Sukses Masuk Dunia Kerja & Lolos Interview',
                'description' => '<p>Dunia kerja membutuhkan kesiapan mental dan soft skills yang matang. Seminar ini dipandu oleh praktisi HR berpengalaman untuk memberikan tips menulis CV ATS-friendly dan teknik wawancara kerja.</p>',
                'excerpt' => 'Seminar persiapan karir, cara membuat CV profesional, dan strategi menghadapi wawancara HRD.',
                'location' => 'Ruang Aula Mini Gedung B',
                'start_datetime' => $now->copy()->subDays(15)->setTime(9, 30, 0),
                'end_datetime' => $now->copy()->subDays(15)->setTime(12, 0, 0),
                'speaker' => 'Rina Kartika, M.Psi. (HR Manager)',
                'organizer' => 'Bursa Kerja Khusus (BKK) Sekolah',
                'category_id' => $getCategoryId('Seminar'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Workshop Cyber Security & Ethical Hacking Essentials',
                'description' => '<p>Membahas dasar-dasar pertahanan keamanan siber, identifikasi kerentanan web (OWASP Top 10), serta cara melindungi infrastruktur sistem informasi dari serangan hacker jahat.</p>',
                'excerpt' => 'Workshop keamanan siber dan pemahaman dasar etika peretasan (ethical hacking) untuk proteksi data.',
                'location' => 'Laboratorium Komputer TJKT 2',
                'start_datetime' => $now->copy()->addMonth()->setDate($now->year, $now->copy()->addMonth()->month, 10)->setTime(9, 0, 0),
                'end_datetime' => $now->copy()->addMonth()->setDate($now->year, $now->copy()->addMonth()->month, 10)->setTime(15, 0, 0),
                'speaker' => 'Yusuf Maulana, CEH (Cyber Security Specialist)',
                'organizer' => 'Program Studi TJKT',
                'category_id' => $getCategoryId('Workshop'),
                'jurusan_id' => $getTjktId,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Lomba Inovasi Teknologi Tepat Guna Tingkat Provinsi',
                'description' => '<p>Ajang kompetisi regional untuk memamerkan inovasi teknologi yang bermanfaat bagi masyarakat umum dan ramah lingkungan.</p>',
                'excerpt' => 'Kompetisi karya teknologi terapan tingkat provinsi Jawa Barat tahun 2026.',
                'location' => 'Pusat Edukasi & Rekreasi Regional',
                'start_datetime' => $now->copy()->addMonth()->setDate($now->year, $now->copy()->addMonth()->month, 20)->setTime(8, 0, 0),
                'end_datetime' => $now->copy()->addMonth()->setDate($now->year, $now->copy()->addMonth()->month, 20)->setTime(17, 0, 0),
                'speaker' => 'Dewan Juri Asosiasi Ilmuwan Indonesia',
                'organizer' => 'Dinas Pemberdayaan Masyarakat',
                'category_id' => $getCategoryId('Lomba / Kompetisi'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Kunjungan Industri Jurusan Akuntansi ke Kantor KPP Pratama',
                'description' => '<p>Kunjungan ini bertujuan memberikan pemahaman mendalam tentang tata cara perpajakan, pengelolaan pelaporan keuangan negara, serta prospek karir di bidang administrasi pajak.</p>',
                'excerpt' => 'Studi lapangan pengenalan sistem administrasi perpajakan dan pelaporan SPT tahunan di KPP.',
                'location' => 'Kantor Pelayanan Pajak (KPP) Pratama',
                'start_datetime' => $now->copy()->subMonth()->setDate($now->year, $now->copy()->subMonth()->month, 12)->setTime(8, 30, 0),
                'end_datetime' => $now->copy()->subMonth()->setDate($now->year, $now->copy()->subMonth()->month, 12)->setTime(13, 0, 0),
                'speaker' => 'Fungsional Penyuluh Pajak KPP',
                'organizer' => 'Program Keahlian AKL',
                'category_id' => $getCategoryId('Kunjungan Industri'),
                'jurusan_id' => $getAklId,
                'period' => $activePeriod,
            ],
        ];

        foreach ($events as $eventData) {
            $slug = Str::slug($eventData['title']);
            
            Event::updateOrCreate(
                ['slug' => $slug],
                array_merge($eventData, [
                    'slug' => $slug,
                    'is_public' => true,
                    'is_active' => true,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ])
            );
        }

        $this->command->info('Successfully seeded ' . count($events) . ' events!');
    }
}
