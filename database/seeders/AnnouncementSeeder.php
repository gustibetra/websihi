<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\Announcement;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
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

        $this->command->info('Seeding Announcement/Pengumuman data...');

        // Get announcement categories from common (table_name = 'kategori_pengumuman')
        $categories = Common::where('table_name', 'kategori_pengumuman')->get()->keyBy('data1');
        
        $getCategoryId = function ($name) use ($categories) {
            return isset($categories[$name]) ? $categories[$name]->id : null;
        };

        // Get programs/jurusans
        $programs = Program::get()->keyBy('kode');
        $getRplId = isset($programs['RPL']) ? $programs['RPL']->id : null;
        $getTjktId = isset($programs['TJKT']) ? $programs['TJKT']->id : null;

        // Current active period
        $activePeriod = Common::where('table_name', 'period')
            ->where('data4', '1') // Active
            ->first()?->data1 ?? '2024-2029';

        $now = Carbon::now();

        $announcements = [
            [
                'title' => 'Pengumuman Pembagian Rapor Semester Genap Tahun Ajaran 2025/2026',
                'content' => '<p>Sehubungan dengan berakhirnya kegiatan belajar mengajar Semester Genap, kami mengumumkan bahwa pembagian Rapor Hasil Belajar Siswa akan dilaksanakan secara langsung di kelas masing-masing.</p><p>Orang tua atau wali murid diwajibkan hadir untuk mengambil rapor dan berdiskusi mengenai perkembangan belajar siswa dengan wali kelas.</p><p>Harap hadir tepat waktu sesuai dengan jadwal yang telah ditentukan dan mematuhi tata tertib sekolah.</p>',
                'excerpt' => 'Informasi pelaksanaan pembagian rapor hasil belajar siswa semester genap kepada orang tua/wali murid.',
                'start_date' => $now->copy(),
                'end_date' => $now->copy()->addDays(7),
                'category_id' => $getCategoryId('Akademik'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Jadwal Pelaksanaan Penilaian Akhir Semester (PAS) Ganjil',
                'content' => '<p>Diberitahukan kepada seluruh siswa kelas X, XI, dan XII bahwa Penilaian Akhir Semester (PAS) Ganjil akan diselenggarakan berbasis komputer (CBT). Kartu peserta ujian dapat diambil melalui wali kelas masing-masing setelah menyelesaikan administrasi perpustakaan.</p><p>Harap persiapkan diri dengan belajar giat dan menjaga kesehatan selama masa ujian berlangsung.</p>',
                'excerpt' => 'Pelaksanaan Penilaian Akhir Semester (PAS) Ganjil berbasis Computer Based Test (CBT).',
                'start_date' => $now->copy()->subDays(10),
                'end_date' => $now->copy()->subDays(1),
                'category_id' => $getCategoryId('Akademik'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Pendaftaran Ekstrakurikuler Wajib dan Pilihan Periode 2026',
                'content' => '<p>Pendaftaran kegiatan ekstrakurikuler untuk tahun ajaran baru telah resmi dibuka. Setiap siswa kelas X diwajibkan mengikuti ekstrakurikuler Pramuka, serta memilih minimal satu ekstrakurikuler pilihan (Paskibra, PMR, Futsal, Basket, Coding Club, atau Seni Musik).</p><p>Pendaftaran dapat dilakukan secara online melalui portal siswa sekolah menggunakan akun masing-masing.</p>',
                'excerpt' => 'Pembukaan pendaftaran ekstrakurikuler pilihan dan wajib bagi seluruh siswa kelas X.',
                'start_date' => $now->copy()->addDays(2),
                'end_date' => $now->copy()->addDays(14),
                'category_id' => $getCategoryId('Kesiswaan'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Pengumuman Kelulusan Siswa Kelas XII Angkatan 2026',
                'content' => '<p>Selamat atas kelulusan siswa-siswi kelas XII SMK Unggulan angkatan tahun 2026! Hasil kelulusan dapat diakses secara resmi melalui portal pengumuman kelulusan sekolah dengan memasukkan nomor ujian nasional atau NISN masing-masing.</p><p>Sekolah mengimbau seluruh siswa untuk bersyukur dengan tertib di rumah masing-masing dan dilarang melakukan konvoi di jalan raya serta aksi coret-coret seragam.</p>',
                'excerpt' => 'Informasi pengumuman kelulusan resmi siswa kelas XII tahun pelajaran 2025/2026.',
                'start_date' => $now->copy()->subDays(5),
                'end_date' => $now->copy()->addDays(3),
                'category_id' => $getCategoryId('Kelulusan'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Informasi Pendaftaran Peserta Didik Baru (PPDB) Jalur Prestasi',
                'content' => '<p>Penerimaan Peserta Didik Baru (PPDB) Jalur Prestasi Akademik dan Non-Akademik resmi dibuka untuk lulusan SMP/MTs sederajat. Jalur ini memberikan kesempatan beasiswa bebas biaya pendidikan bagi calon siswa yang memiliki sertifikat kejuaraan tingkat kabupaten, provinsi, maupun nasional.</p><p>Silakan unduh brosur dan syarat lengkap pendaftaran pada lampiran dokumen pengumuman ini.</p>',
                'excerpt' => 'Pembukaan pendaftaran siswa baru (PPDB) jalur prestasi akademik dan non-akademik.',
                'start_date' => $now->copy()->addDays(5),
                'end_date' => $now->copy()->addDays(20),
                'category_id' => $getCategoryId('PPDB'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Pemberitahuan Hari Libur Semester Genap dan Cuti Bersama',
                'content' => '<p>Berdasarkan kalender akademik sekolah dan surat keputusan dinas pendidikan, diumumkan bahwa libur semester genap akan berlangsung. Selama masa libur, kegiatan administrasi sekolah tetap berjalan secara terbatas.</p><p>Siswa diharapkan memanfaatkan waktu libur untuk beristirahat dan berkumpul bersama keluarga di rumah secara aman.</p>',
                'excerpt' => 'Surat pemberitahuan resmi mengenai hari libur semester genap sekolah dan cuti bersama.',
                'start_date' => $now->copy()->subDays(30),
                'end_date' => $now->copy()->subDays(15),
                'category_id' => $getCategoryId('Libur Sekolah'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Pendaftaran Program Beasiswa Prestasi dan Bantuan Biaya Pendidikan',
                'content' => '<p>Dibuka pendaftaran beasiswa internal sekolah bagi siswa kurang mampu berprestasi (BKM) dan beasiswa dari komite sekolah. Program ini mencakup bantuan kuota internet, buku paket, serta keringanan biaya sumbangan pendidikan.</p><p>Persyaratan mencakup surat keterangan tidak mampu (SKTM) dari kelurahan dan fotokopi rapor semester terakhir.</p>',
                'excerpt' => 'Kesempatan beasiswa bantuan biaya sekolah untuk siswa berprestasi dan kurang mampu.',
                'start_date' => $now->copy()->addDays(1),
                'end_date' => $now->copy()->addDays(10),
                'category_id' => $getCategoryId('Beasiswa'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Pelaksanaan Asesmen Nasional Berbasis Komputer (ANBK) Tingkat SMK',
                'content' => '<p>Asesmen Nasional Berbasis Komputer (ANBK) untuk mendongkrak mutu pendidikan sekolah akan dilaksanakan. Kegiatan ini diikuti oleh siswa kelas XI yang terpilih secara acak oleh sistem Kemendikbudristek.</p><p>Simulasi dan gladi bersih akan diselenggarakan di laboratorium komputer utama sekolah.</p>',
                'excerpt' => 'Jadwal persiapan simulasi dan pelaksanaan ANBK nasional bagi siswa kelas XI.',
                'start_date' => $now->copy()->subDays(15),
                'end_date' => $now->copy()->addDays(1),
                'category_id' => $getCategoryId('Akademik'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Pengumuman Hasil Seleksi Pengurus OSIS & MPK Masa Bakti 2026/2027',
                'content' => '<p>Berdasarkan hasil musyawarah perwakilan kelas dan serangkaian tes fit and proper test yang diselenggarakan panitia seleksi, berikut adalah nama-nama siswa yang dinyatakan lolos sebagai Pengurus Harian OSIS dan MPK Sekolah baru.</p><p>Pelantikan resmi akan dilaksanakan pada upacara bendera hari Senin mendatang.</p>',
                'excerpt' => 'Hasil kelulusan seleksi akhir pengurus OSIS dan Majelis Perwakilan Kelas (MPK) periode baru.',
                'start_date' => $now->copy()->addDays(3),
                'end_date' => $now->copy()->addDays(8),
                'category_id' => $getCategoryId('Kesiswaan'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
            [
                'title' => 'Jadwal Pengambilan Ijazah dan Cap Tiga Jari Kelas XII',
                'content' => '<p>Diberitahukan kepada seluruh alumni angkatan 2026 bahwa blangko ijazah asli telah siap. Proses sidik jari (cap tiga jari) dan pengambilan ijazah dilayani pada jam kerja di ruang tata usaha (TU).</p><p>Alumni diwajibkan memakai pakaian rapi (berkerah, bukan kaos) dan bersepatu saat memasuki area sekolah.</p>',
                'excerpt' => 'Agenda jadwal pelayanan cap tiga jari ijazah asli kelulusan bagi alumni kelas XII.',
                'start_date' => $now->copy()->subDays(2),
                'end_date' => $now->copy()->addDays(5),
                'category_id' => $getCategoryId('Kelulusan'),
                'jurusan_id' => null,
                'period' => $activePeriod,
            ],
        ];

        foreach ($announcements as $announcementData) {
            $slug = Str::slug($announcementData['title']);
            
            Announcement::updateOrCreate(
                ['slug' => $slug],
                array_merge($announcementData, [
                    'slug' => $slug,
                    'is_public' => true,
                    'is_active' => true,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ])
            );
        }

        $this->command->info('Successfully seeded ' . count($announcements) . ' announcements!');
    }
}
