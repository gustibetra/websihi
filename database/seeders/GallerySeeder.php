<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
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

        $this->command->info('Seeding Gallery data...');

        // Get gallery categories from common (table_name = 'kategori_galeri')
        $categories = Common::where('table_name', 'kategori_galeri')->get()->keyBy('data1');
        
        $getCategoryId = function ($name) use ($categories) {
            return isset($categories[$name]) ? $categories[$name]->id : null;
        };

        // Get programs/jurusans
        $programs = Program::get()->keyBy('kode');
        $getRplId = isset($programs['RPL']) ? $programs['RPL']->id : null;
        $getTjktId = isset($programs['TJKT']) ? $programs['TJKT']->id : null;

        $galleriesData = [
            [
                'title' => 'Kegiatan Belajar Mengajar Praktikum IoT RPL',
                'description' => 'Dokumentasi kegiatan praktikum pemrograman Internet of Things (IoT) siswa kelas XI program keahlian Rekayasa Perangkat Lunak di laboratorium komputer.',
                'category_id' => $getCategoryId('Kegiatan Sekolah'),
                'jurusan_id' => $getRplId,
            ],
            [
                'title' => 'Pelepasan Siswa PKL Jurusan Teknik Jaringan Komputer',
                'description' => 'Acara pembekalan dan pelepasan resmi siswa kelas XI Teknik Jaringan Komputer dan Telekomunikasi (TJKT) yang akan melaksanakan Praktik Kerja Lapangan (PKL) di industri mitra.',
                'category_id' => $getCategoryId('PKL'),
                'jurusan_id' => $getTjktId,
            ],
            [
                'title' => 'Pemenang Juara 1 Lomba Web Design Tingkat Nasional',
                'description' => 'Momen kebanggaan penyerahan piala dan penghargaan bagi siswa perwakilan sekolah yang berhasil meraih Juara 1 dalam ajang Lomba Desain Web Nasional.',
                'category_id' => $getCategoryId('Prestasi'),
                'jurusan_id' => $getRplId,
            ],
            [
                'title' => 'Workshop Cloud Computing Modern bersama AWS Academy',
                'description' => 'Pelaksanaan workshop intensif teknologi komputasi awan (Cloud Computing) bagi siswa tingkat akhir TJKT yang bekerja sama dengan instruktur bersertifikasi AWS.',
                'category_id' => $getCategoryId('Workshop'),
                'jurusan_id' => $getTjktId,
            ],
            [
                'title' => 'Kemeriahan Kegiatan MPLS Siswa Baru Angkatan 2026',
                'description' => 'Dokumentasi berbagai keseruan dan materi orientasi lingkungan sekolah (MPLS) bagi siswa-siswi baru di lapangan utama dan aula sekolah.',
                'category_id' => $getCategoryId('MPLS'),
                'jurusan_id' => null,
            ],
            [
                'title' => 'Wisuda dan Pelepasan Siswa Kelas XII Tahun 2026',
                'description' => 'Rangkaian prosesi wisuda kelulusan dan upacara pelepasan siswa kelas XII tahun pelajaran 2025/2026 yang berlangsung khidmat.',
                'category_id' => $getCategoryId('Wisuda'),
                'jurusan_id' => null,
            ],
            [
                'title' => 'Kunjungan Industri Jurusan Akuntansi ke Bank Indonesia',
                'description' => 'Studi lapangan dan pengenalan operasional sistem moneter serta tata kelola keuangan negara bagi siswa Akuntansi (AKL) di kantor Bank Indonesia.',
                'category_id' => $getCategoryId('Kegiatan Sekolah'),
                'jurusan_id' => null,
            ],
            [
                'title' => 'Aksi Sosial dan Bakti Masyarakat OSIS SMK Unggulan',
                'description' => 'Dokumentasi kegiatan bakti sosial pembagian sembako dan bersih-bersih lingkungan sekitar sekolah oleh pengurus OSIS.',
                'category_id' => $getCategoryId('Kegiatan Sekolah'),
                'jurusan_id' => null,
            ],
            [
                'title' => 'Lomba Futsal dan Olahraga Antar Kelas Classmeeting',
                'description' => 'Momen keseruan pertandingan futsal, voli, dan tarik tambang antar kelas pasca ujian semester ganjil.',
                'category_id' => $getCategoryId('Lomba'),
                'jurusan_id' => null,
            ],
            [
                'title' => 'Ujian Kompetensi Keahlian (UKK) Program Keahlian RPL',
                'description' => 'Dokumentasi pelaksanaan ujian praktik keahlian siswa tingkat akhir program Rekayasa Perangkat Lunak yang dinilai langsung oleh asesor industri.',
                'category_id' => $getCategoryId('Kegiatan Sekolah'),
                'jurusan_id' => $getRplId,
            ],
        ];

        foreach ($galleriesData as $data) {
            $slug = Str::slug($data['title']);
            
            // Create or update the gallery
            $gallery = Gallery::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $data['title'],
                    'slug' => $slug,
                    'description' => $data['description'],
                    'category_id' => $data['category_id'],
                    'jurusan_id' => $data['jurusan_id'],
                    'upload_by' => $user->id,
                ]
            );

            // Seed exactly 3 images for each gallery (gallery-01.jpg, gallery-02.jpg, gallery-03.jpg)
            $defaultImages = ['gallery-01.jpg', 'gallery-02.jpg', 'gallery-03.jpg'];
            
            // Clear existing images to prevent duplication on re-run
            $gallery->images()->delete();

            foreach ($defaultImages as $index => $imageName) {
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $imageName,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        $this->command->info('Successfully seeded ' . count($galleriesData) . ' galleries with 3 photos each!');
    }
}
