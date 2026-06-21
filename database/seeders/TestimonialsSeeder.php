<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get creator
        $user = User::first();
        $userId = $user ? $user->id : 1;

        $this->command->info('Truncating testimonials table and preparing seeds...');
        
        // Truncate table to ensure exactly 15 records
        Testimonial::truncate();

        // Ensure directory exists
        Storage::disk('public')->makeDirectory('testimonials');

        // Copy dummy avatars for premium visuals
        $photos = [];
        for ($i = 1; $i <= 12; $i++) {
            $num = sprintf('%02d', $i);
            $src = public_path("assets/site/images/testimonial/client-{$num}.png");
            $dest = "testimonials/testimonial-{$num}.png";
            if (File::exists($src)) {
                File::copy($src, storage_path('app/public/' . $dest));
                $photos[$i] = $dest;
            } else {
                $photos[$i] = 'testimonials/dummy.jpg';
            }
        }

        // If dummy.jpg doesn't exist, create it
        $dummyDest = storage_path('app/public/testimonials/dummy.jpg');
        if (!File::exists($dummyDest)) {
            $sourceDummy = public_path('assets/admin/images/users/user-dummy-img.jpg');
            if (File::exists($sourceDummy)) {
                File::copy($sourceDummy, $dummyDest);
            } else {
                $dummyContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=');
                Storage::disk('public')->put('testimonials/dummy.jpg', $dummyContent);
            }
        }

        $list = [
            [
                'name' => 'Prof. Dr. Ir. H. Herman Subarjah, M.Si.',
                'role' => 'Guru Besar Universitas Pendidikan Indonesia',
                'photo' => $photos[1] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Kerjasama riset dan pengabdian masyarakat kami dengan sekolah ini menunjukkan bahwa kompetensi teknis dan karakter siswa sangat unggul dan berstandar nasional.',
            ],
            [
                'name' => 'Ir. Budi Rahardjo, M.Sc., Ph.D.',
                'role' => 'Praktisi IT & Dosen Sekolah Teknik Elektro dan Informatika ITB',
                'photo' => $photos[2] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Lulusan dari program Rekayasa Perangkat Lunak sekolah ini memiliki logika pemrograman yang matang dan sangat siap menghadapi dinamika perkuliahan IT.',
            ],
            [
                'name' => 'H. Rahmat Hidayat, M.B.A.',
                'role' => 'Orang Tua Siswa (Kelas XII RPL 1)',
                'photo' => $photos[3] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Fasilitas belajar yang sangat modern dan lingkungan sekolah yang religius membuat saya sangat yakin menyekolahkan anak saya di sini. Terbukti anak saya sudah bisa magang di startup ternama.',
            ],
            [
                'name' => 'Sofia Lestari, S.E.',
                'role' => 'Manager HRD PT GoTo Gojek Tokopedia Tbk',
                'photo' => $photos[4] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Kami telah merekrut beberapa alumni dari jurusan Akuntansi dan RPL. Mereka memiliki etos kerja yang tinggi, cepat beradaptasi, dan skill teknis yang mumpuni.',
            ],
            [
                'name' => 'Drs. H. Wahyudin, M.Pd.',
                'role' => 'Pengawas SMK Dinas Pendidikan Provinsi Jawa Barat',
                'photo' => $photos[5] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Sekolah ini konsisten menjadi role model bagi sekolah kejuruan lainnya di Jawa Barat dalam penerapan kurikulum merdeka dan link and match dengan dunia industri.',
            ],
            [
                'name' => 'Anita Wulandari, S.Psi.',
                'role' => 'Orang Tua Siswa (Kelas XI TJKT)',
                'photo' => $photos[6] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Sistem pendidikan karakter dan kedisiplinan di sekolah ini sangat luar biasa. Anak saya menunjukkan perubahan sikap yang lebih mandiri, sopan, dan bertanggung jawab sejak masuk ke sini.',
            ],
            [
                'name' => 'Hendra Wijaya, S.T.',
                'role' => 'Chief Technology Officer PT Telkom Sigma',
                'photo' => $photos[7] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Siswa prakerin dari kompetensi keahlian Teknik Jaringan Komputer dan Telekomunikasi di sini memiliki pemahaman infrastruktur jaringan yang sangat baik dan bersertifikasi industri.',
            ],
            [
                'name' => 'Dr. Kartika Sari, M.Si.',
                'role' => 'Ketua Komite Sekolah',
                'photo' => $photos[8] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Transparansi tata kelola sekolah dan sinergi yang harmonis antara sekolah, komite, dan orang tua menjadi pilar penting keberhasilan berbagai program unggulan.',
            ],
            [
                'name' => 'M. Yusuf Firmansyah',
                'role' => 'Alumni Angkatan 2017 / Owner Start-Up "Creative Studio"',
                'photo' => $photos[9] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Pendidikan kewirausahaan di SMK ini memberikan saya keberanian dan bekal operasional untuk merintis bisnis kreatif sendiri langsung setelah lulus sekolah.',
            ],
            [
                'name' => 'Farida Nuraini, Ak.',
                'role' => 'Senior Auditor Kantor Akuntan Publik (KAP) Tanubrata',
                'photo' => $photos[10] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Kemampuan praktis siswa jurusan Akuntansi dalam mengoperasikan software akuntansi Accurate dan MYOB sangat rapi dan sesuai dengan standar kebutuhan industri keuangan saat ini.',
            ],
            [
                'name' => 'Rian Hidayat, M.Kom.',
                'role' => 'Alumni Angkatan 2019 / Senior Engineer Shopee',
                'photo' => $photos[11] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Saya mendapatkan bekal pondasi coding yang sangat kokoh dari guru-guru hebat di sekolah ini. Pengalaman praktek kerjanya membuka wawasan industri sejak dini.',
            ],
            [
                'name' => 'Dr. H. Ahmad Dahlan, M.Ag.',
                'role' => 'Tokoh Masyarakat & Komite Bidang Keagamaan',
                'photo' => $photos[12] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Program pembiasaan keagamaan seperti shalat dhuha berjamaah dan tahfidz Quran di sekolah ini berhasil mencetak lulusan yang cerdas secara intelektual dan berakhlak mulia.',
            ],
            [
                'name' => 'Diana Putri, S.E.',
                'role' => 'Orang Tua Siswa (Kelas X AKL 2)',
                'photo' => $photos[1] ?? 'testimonials/dummy.jpg',
                'rating' => 4,
                'content' => 'Sangat puas dengan pelayanan administrasi sekolah dan cara guru berkomunikasi memantau perkembangan belajar anak lewat buku penghubung online.',
            ],
            [
                'name' => 'Taufik Hidayat, S.Kom.',
                'role' => 'IT Infrastructure Specialist PT Indosat Ooredoo Hutchison',
                'photo' => $photos[2] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Kurikulum jaringan Cisco dan Mikrotik yang diintegrasikan dengan materi sekolah benar-benar memberikan percepatan karir bagi siswa lulusan TJKT.',
            ],
            [
                'name' => 'Sri Wahyuni, M.Pd.',
                'role' => 'Kepala Balai Penjaminan Mutu Pendidikan (BPMP) Jabar',
                'photo' => $photos[3] ?? 'testimonials/dummy.jpg',
                'rating' => 5,
                'content' => 'Sekolah ini secara konsisten menunjukkan rapor pendidikan dengan predikat sangat baik dan meraih berbagai penghargaan inovasi pembelajaran di tingkat regional.',
            ],
        ];

        $order = 1;
        foreach ($list as $data) {
            Testimonial::create(array_merge($data, [
                'order' => $order++,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]));
        }

        $this->command->info('Successfully seeded exactly 15 general testimonials!');
    }
}
