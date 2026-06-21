<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\Download;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DownloadSeeder extends Seeder
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

        $this->command->info('Seeding Download Center data...');

        // Get download categories from common (table_name = 'kategori_download')
        $categories = Common::where('table_name', 'kategori_download')->get()->keyBy('data1');
        
        $getCategoryId = function ($name) use ($categories) {
            return isset($categories[$name]) ? $categories[$name]->id : null;
        };

        // Get programs/jurusans
        $programs = Program::get()->keyBy('kode');
        $getRplId = isset($programs['RPL']) ? $programs['RPL']->id : null;
        $getTjktId = isset($programs['TJKT']) ? $programs['TJKT']->id : null;
        $getAklId = isset($programs['AKL']) ? $programs['AKL']->id : null;

        $now = Carbon::now();

        $downloads = [
            [
                'title' => 'Formulir Pendaftaran Siswa Baru (PPDB) Tahun Ajaran 2026/2027',
                'category_id' => $getCategoryId('Formulir'),
                'jurusan_id' => null,
                'file_path' => 'documents/formulir_ppdb_2026.pdf',
                'file_size' => '450 KB',
                'description' => 'Formulir resmi untuk pendaftaran calon peserta didik baru SMK Unggulan angkatan tahun ajaran 2026/2027.',
                'created_at' => $now->copy()->subDays(10),
            ],
            [
                'title' => 'Brosur Sekolah & Program Keahlian Unggulan 2026',
                'category_id' => $getCategoryId('Brosur & Leaflet'),
                'jurusan_id' => null,
                'file_path' => 'documents/brosur_sekolah_2026.pdf',
                'file_size' => '3.2 MB',
                'description' => 'Brosur profil lengkap sekolah, fasilitas, daftar ekstrakurikuler, dan keunggulan tiap kompetensi keahlian.',
                'created_at' => $now->copy()->subDays(9),
            ],
            [
                'title' => 'Kalender Akademik Tahun Pelajaran 2026/2027',
                'category_id' => $getCategoryId('Kalender Akademik'),
                'jurusan_id' => null,
                'file_path' => 'documents/kalender_akademik_2026.pdf',
                'file_size' => '1.1 MB',
                'description' => 'Kalender jadwal kegiatan belajar mengajar, penilaian tengah/akhir semester, dan hari libur nasional.',
                'created_at' => $now->copy()->subDays(8),
            ],
            [
                'title' => 'Buku Panduan Tata Tertib & Kode Etik Siswa',
                'category_id' => $getCategoryId('Panduan & SOP'),
                'jurusan_id' => null,
                'file_path' => 'documents/tata_tertib_siswa.pdf',
                'file_size' => '850 KB',
                'description' => 'Dokumen regulasi tata tertib siswa, poin pelanggaran, hak dan kewajiban siswa di lingkungan sekolah.',
                'created_at' => $now->copy()->subDays(7),
            ],
            [
                'title' => 'SOP Pelaksanaan Praktik Kerja Lapangan (PKL) Siswa',
                'category_id' => $getCategoryId('Panduan & SOP'),
                'jurusan_id' => null,
                'file_path' => 'documents/sop_pkl_siswa.pdf',
                'file_size' => '1.4 MB',
                'description' => 'Standar operasional prosedur pengajuan, pelaksanaan, dan pelaporan kegiatan Praktik Kerja Lapangan (PKL).',
                'created_at' => $now->copy()->subDays(6),
            ],
            [
                'title' => 'Dokumen Kurikulum Operasional Satuan Pendidikan (KOSP)',
                'category_id' => $getCategoryId('Dokumen Resmi'),
                'jurusan_id' => null,
                'file_path' => 'documents/kurikulum_kosp_smk.pdf',
                'file_size' => '2.8 MB',
                'description' => 'Kurikulum operasional sekolah yang memuat profil lulusan, struktur kurikulum, dan beban belajar siswa.',
                'created_at' => $now->copy()->subDays(5),
            ],
            [
                'title' => 'Modul Ajar Dasar-Dasar Pemrograman (HTML/CSS/JS)',
                'category_id' => $getCategoryId('Materi Pembelajaran'),
                'jurusan_id' => $getRplId,
                'file_path' => 'documents/modul_rpl_pemrograman.pdf',
                'file_size' => '4.5 MB',
                'description' => 'Buku panduan praktikum pemrograman web dasar untuk siswa kelas X jurusan Rekayasa Perangkat Lunak.',
                'created_at' => $now->copy()->subDays(5),
            ],
            [
                'title' => 'Panduan Keselamatan Kerja & Penggunaan Lab Komputer Jaringan',
                'category_id' => $getCategoryId('Panduan & SOP'),
                'jurusan_id' => $getTjktId,
                'file_path' => 'documents/panduan_lab_tjkt.pdf',
                'file_size' => '1.9 MB',
                'description' => 'SOP keselamatan kerja, tata cara penggunaan perangkat router, switch, dan cabling di laboratorium TJKT.',
                'created_at' => $now->copy()->subDays(4),
            ],
            [
                'title' => 'Modul Praktikum Administrasi & Infrastruktur Jaringan Kelas XI',
                'category_id' => $getCategoryId('Materi Pembelajaran'),
                'jurusan_id' => $getTjktId,
                'file_path' => 'documents/modul_jaringan_tjkt.pdf',
                'file_size' => '5.2 MB',
                'description' => 'Materi praktikum konfigurasi routing dinamis, VLAN, dan firewall menggunakan simulator jaringan Cisco Packet Tracer.',
                'created_at' => $now->copy()->subDays(4),
            ],
            [
                'title' => 'Modul Pembelajaran Akuntansi Keuangan Dasar Kelas X',
                'category_id' => $getCategoryId('Materi Pembelajaran'),
                'jurusan_id' => $getAklId,
                'file_path' => 'documents/modul_akuntansi_dasar.pdf',
                'file_size' => '3.8 MB',
                'description' => 'Modul ajar mencakup pengenalan persamaan dasar akuntansi, jurnal umum, buku besar, dan siklus akuntansi jasa.',
                'created_at' => $now->copy()->subDays(3),
            ],
            [
                'title' => 'Formulir Pengajuan Beasiswa Komite Kurang Mampu (BKM)',
                'category_id' => $getCategoryId('Formulir'),
                'jurusan_id' => null,
                'file_path' => 'documents/formulir_beasiswa_bkm.pdf',
                'file_size' => '280 KB',
                'description' => 'Formulir permohonan keringanan biaya sekolah dan pengajuan beasiswa BKM dari Komite Sekolah.',
                'created_at' => $now->copy()->subDays(3),
            ],
            [
                'title' => 'Formulir Pendaftaran Ekstrakurikuler Sekolah',
                'category_id' => $getCategoryId('Formulir'),
                'jurusan_id' => null,
                'file_path' => 'documents/formulir_ekstrakurikuler.pdf',
                'file_size' => '150 KB',
                'description' => 'Form pendaftaran anggota baru ekstrakurikuler wajib Pramuka maupun pilihan (PMR, Futsal, Coding Club).',
                'created_at' => $now->copy()->subDays(2),
            ],
            [
                'title' => 'Leaflet Profil Kompetensi Keahlian Rekayasa Perangkat Lunak',
                'category_id' => $getCategoryId('Brosur & Leaflet'),
                'jurusan_id' => $getRplId,
                'file_path' => 'documents/leaflet_rpl.pdf',
                'file_size' => '1.5 MB',
                'description' => 'Pamflet promosi jurusan RPL yang berisi prospek kerja, materi utama keahlian, dan prestasi siswa.',
                'created_at' => $now->copy()->subDays(2),
            ],
            [
                'title' => 'Leaflet Profil Kompetensi Keahlian Teknik Jaringan Komputer & Telekomunikasi',
                'category_id' => $getCategoryId('Brosur & Leaflet'),
                'jurusan_id' => $getTjktId,
                'file_path' => 'documents/leaflet_tjkt.pdf',
                'file_size' => '1.7 MB',
                'description' => 'Leaflet informasi kurikulum TJKT, sertifikasi kompetensi Mikrotik/Cisco, dan prospek karir alumni.',
                'created_at' => $now->copy()->subDays(1),
            ],
            [
                'title' => 'Leaflet Profil Kompetensi Keahlian Akuntansi & Keuangan Lembaga',
                'category_id' => $getCategoryId('Brosur & Leaflet'),
                'jurusan_id' => $getAklId,
                'file_path' => 'documents/leaflet_akl.pdf',
                'file_size' => '1.3 MB',
                'description' => 'Brosur ringkas program keahlian AKL mengenai lab manual/komputer akuntansi Accurate dan MYOB.',
                'created_at' => $now->copy()->subDays(1),
            ],
            [
                'title' => 'Jadwal Pelajaran & Kalender Kegiatan Kelas X Semester Ganjil',
                'category_id' => $getCategoryId('Kalender Akademik'),
                'jurusan_id' => null,
                'file_path' => 'documents/jadwal_kegiatan_kelas10.pdf',
                'file_size' => '920 KB',
                'description' => 'Pembagian jadwal pelajaran mingguan dan jadwal bimbingan akademik kelas X.',
                'created_at' => $now->copy(),
            ],
            [
                'title' => 'Jadwal Pelajaran & Kalender Kegiatan Kelas XI Semester Ganjil',
                'category_id' => $getCategoryId('Kalender Akademik'),
                'jurusan_id' => null,
                'file_path' => 'documents/jadwal_kegiatan_kelas11.pdf',
                'file_size' => '940 KB',
                'description' => 'Pembagian jadwal pelajaran mingguan dan jadwal persiapan pelaksanaan PKL kelas XI.',
                'created_at' => $now->copy(),
            ],
            [
                'title' => 'Jadwal Pelajaran & Kalender Kegiatan Kelas XII Semester Ganjil',
                'category_id' => $getCategoryId('Kalender Akademik'),
                'jurusan_id' => null,
                'file_path' => 'documents/jadwal_kegiatan_kelas12.pdf',
                'file_size' => '950 KB',
                'description' => 'Pembagian jadwal pelajaran mingguan, jadwal persiapan Ujian Sekolah dan UKK kelas XII.',
                'created_at' => $now->copy(),
            ],
            [
                'title' => 'Rencana Pelaksanaan Pembelajaran (RPP) Pemrograman Berorientasi Objek',
                'category_id' => $getCategoryId('Materi Pembelajaran'),
                'jurusan_id' => $getRplId,
                'file_path' => 'documents/rpp_rpl_oop.pdf',
                'file_size' => '2.1 MB',
                'description' => 'RPP mata pelajaran Pemrograman Berorientasi Objek (OOP) kelas XI RPL sebagai pedoman KBM.',
                'created_at' => $now->copy(),
            ],
            [
                'title' => 'SOP Penilaian & Ujian Kompetensi Keahlian (UKK) Akuntansi',
                'category_id' => $getCategoryId('Panduan & SOP'),
                'jurusan_id' => $getAklId,
                'file_path' => 'documents/sop_ukk_akl.pdf',
                'file_size' => '1.1 MB',
                'description' => 'Prosedur penilaian, kriteria kelulusan, dan jadwal pengujian eksternal UKK bagi siswa kelas XII AKL.',
                'created_at' => $now->copy(),
            ],
        ];

        foreach ($downloads as $data) {
            Download::updateOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'is_active' => true,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ])
            );
        }

        $this->command->info('Successfully seeded 20 download documents!');
    }
}
