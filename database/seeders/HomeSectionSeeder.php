<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class HomeSectionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $userId = $admin ? $admin->id : 1;

        // Clean up deleted sections from database
        DB::table('common')
            ->where('table_name', 'home_section')
            ->whereIn('key1', ['social_media_embed', 'kontak_lokasi'])
            ->delete();

        // 1. Seed home_section configurations (Active sections list)
        $sections = [
            [
                'key1' => 'hero_banner',
                'data1' => 'Hero Banner',
                'data2' => null,
                'data3' => null,
                'data4' => null,
                'text1' => null,
                'text2' => null,
            ],
            [
                'key1' => 'sambutan',
                'data1' => 'Sambutan Kepala Sekolah',
                'data2' => null, // Photo path
                'data3' => 'Dr. H. Ahmad Fauzi, M.Pd.', // Nama kepala sekolah
                'data4' => 'Kepala Sekolah', // Jabatan
                'data5' => 'Sambutan Kepala Sekolah', // Judul sambutan
                'data6' => 'Kurikulum Merdeka berorientasi industri', // Kata kunci 1
                'data7' => 'Lulusan siap kerja, siap kuliah, siap wirausaha', // Kata kunci 2
                'text1' => 'Assalamualaikum Wr. Wb. Selamat datang di website resmi sekolah kami. Kami berkomitmen untuk menyelenggarakan pendidikan berkualitas tinggi yang relevan dengan kebutuhan industri masa kini. Didukung dengan fasilitas modern serta pengajar yang berkompeten, kami mendidik siswa menjadi insan profesional dan berakhlak mulia.',
            ],
            [
                'key1' => 'statistik',
                'data1' => 'Statistik Sekolah',
                'data2' => 'Siswa Aktif',
                'data3' => '1,200+',
                'data4' => 'Pendidik & Staf',
                'data5' => '85',
                'data6' => 'Program Keahlian',
                'data7' => '3',
                'data8' => 'Mitra Industri',
                'data9' => '50+',
            ],
            [
                'key1' => 'program_keahlian',
                'data1' => 'Program Keahlian',
                'data2' => 'Program Keahlian Terbaik',
                'text1' => 'Pilihan program keahlian yang relevan dengan perkembangan industri global.',
            ],
            [
                'key1' => 'program_unggulan',
                'data1' => 'Program Unggulan',
                'data2' => 'Program Unggulan Sekolah',
                'text1' => 'Program unggulan untuk mengasah hard skill and soft skill siswa secara optimal.',
            ],
            [
                'key1' => 'mitra_industri',
                'data1' => 'Mitra Industri',
                'data2' => 'Kerjasama Industri (DU/DI)',
                'text1' => 'Didukung oleh perusahaan nasional dan internasional terpercaya dalam penyaluran kerja dan magang.',
            ],
            [
                'key1' => 'prestasi_siswa',
                'data1' => 'Prestasi Siswa',
                'data2' => 'Prestasi Terbaru Siswa',
                'text1' => 'Prestasi membanggakan dari siswa-siswi terbaik kami di berbagai bidang perlombaan.',
            ],
            [
                'key1' => 'prestasi_sekolah',
                'data1' => 'Prestasi & Penghargaan Sekolah',
                'data2' => 'Penghargaan & Prestasi Sekolah',
                'text1' => 'Penghargaan resmi atas kualitas tata kelola, inovasi, dan prestasi institusi kami.',
            ],
            [
                'key1' => 'karya_siswa',
                'data1' => 'Karya & Projek Siswa',
                'data2' => 'Karya Kreatif & Projek Siswa',
                'text1' => 'Inovasi, produk kreatif, dan portofolio orisinal buatan siswa-siswi kami.',
            ],
            [
                'key1' => 'berita_terbaru',
                'data1' => 'Berita Terbaru',
                'data2' => 'Kabar & Informasi Terkini',
                'text1' => 'Ikuti berita terkini mengenai berbagai kegiatan, pengumuman, dan agenda di sekolah kami.',
            ],
            [
                'key1' => 'agenda_event',
                'data1' => 'Agenda & Event',
                'data2' => 'Agenda & Kegiatan Sekolah',
                'text1' => 'Pantau jadwal acara, ujian, pertemuan wali murid, dan kegiatan mendatang.',
            ],
            [
                'key1' => 'galeri',
                'data1' => 'Galeri Kegiatan',
                'data2' => 'Galeri Dokumentasi Kegiatan',
                'text1' => 'Dokumentasi visual dari berbagai aktivitas edukasi, sosial, dan prestasi di sekolah.',
            ],
            [
                'key1' => 'alumni_berprestasi',
                'data1' => 'Alumni Berprestasi',
                'data2' => 'Testimoni & Kisah Sukses Alumni',
                'text1' => 'Inspirasi dan kisah sukses para lulusan kami yang telah berkiprah di dunia industri dan perguruan tinggi.',
            ],
            [
                'key1' => 'testimoni',
                'data1' => 'Testimoni',
                'data2' => 'Apa Kata Mereka?',
                'text1' => 'Pendapat para orang tua siswa, tokoh industri, dan masyarakat tentang kualitas pendidikan kami.',
            ],
            [
                'key1' => 'ppdb',
                'data1' => 'PPDB',
                'data2' => 'Penerimaan Peserta Didik Baru',
                'data3' => 'Daftar Sekarang',
                'data4' => '/ppdb',
                'text1' => 'Ayo bergabung bersama keluarga besar sekolah kami! Pendaftaran online PPDB tahun ajaran baru telah resmi dibuka.',
            ],
            [
                'key1' => 'school_life',
                'data1' => 'School Life',
                'data2' => null,
                'data3' => 'https://www.youtube.com/watch?v=nA1Aqp0sPQo',
                'data4' => 'School Life',
                'data5' => 'Kehidupan Sekolah',
                'data6' => '99%',
                'data7' => 'Puas',
                'data8' => 'Pembelajaran Fleksibel',
                'data9' => 'feather-heart',
                'data10' => 'Belajar di Mana Saja',
                'data11' => 'feather-book',
                'data12' => 'Berbasis Praktik',
                'data13' => 'feather-award',
                'text1' => 'Fakta yang terbukti bahwa siswa dapat belajar dengan nyaman menggunakan kurikulum fleksibel kami.',
                'text2' => 'Akses materi pembelajaran secara online kapan saja dan di mana saja tanpa hambatan.',
                'text3' => 'Kurikulum dirancang untuk meningkatkan keterampilan nyata yang siap digunakan di dunia kerja.',
            ],
            [
                'key1' => 'fasilitas',
                'data1' => 'Fasilitas Sekolah',
                'text1' => 'Fasilitas dan sarana prasarana yang lengkap dan modern untuk menunjang kegiatan pembelajaran.',
            ],
            [
                'key1' => 'faq',
                'data1' => 'Frequently Asked Questions',
                'text1' => 'Pertanyaan yang sering diajukan mengenai sekolah kami.',
            ],
        ];

        $order = 1;
        foreach ($sections as $sec) {
            DB::table('common')->updateOrInsert(
                [
                    'table_name' => 'home_section',
                    'key1' => $sec['key1'],
                ],
                array_merge($sec, [
                    'is_active' => true,
                    'order' => $order++,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // 2. Seed Hero Banner Slides CRUD defaults (Multiple Slides)
        $slides = [
            [
                'key1' => 'HB01',
                'data1' => 'Mewujudkan Generasi Unggul dan Berkarakter',
                'text1' => 'Selamat Datang di Portal Resmi Sekolah Kami. Kami siap membimbing dan mengantarkan putra-putri Anda menuju masa depan cemerlang.',
                'data2' => null,
                'data3' => 'Lihat Selengkapnya',
                'data4' => '#',
            ],
            [
                'key1' => 'HB02',
                'data1' => 'Pendidikan Kreatif & Berbasis Teknologi',
                'text1' => 'Mempersiapkan siswa didik dengan kompetensi digital yang siap bersaing secara global di era modern.',
                'data2' => null,
                'data3' => 'Program Unggulan',
                'data4' => '#',
            ],
        ];

        foreach ($slides as $slide) {
            DB::table('common')->updateOrInsert(
                [
                    'table_name' => 'hero_banner_slide',
                    'key1' => $slide['key1'],
                ],
                array_merge($slide, [
                    'is_active' => true,
                    'order' => 0,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
