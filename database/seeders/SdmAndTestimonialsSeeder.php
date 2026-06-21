<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Alumni;
use App\Models\StructuralMember;
use App\Models\Testimonial;
use App\Models\Common;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SdmAndTestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get creator
        $user = User::first();
        $userId = $user ? $user->id : 1;

        $this->command->info('Seeding SDM & Testimonial data...');

        // Ensure directories exist and copy dummy image
        Storage::disk('public')->makeDirectory('students');
        Storage::disk('public')->makeDirectory('alumni');
        Storage::disk('public')->makeDirectory('structural');
        Storage::disk('public')->makeDirectory('testimonials');

        $sourceDummy = public_path('assets/admin/images/users/user-dummy-img.jpg');
        
        $studentPhoto = 'students/dummy.jpg';
        $alumniPhoto = 'alumni/dummy.jpg';
        $structuralPhoto = 'structural/dummy.jpg';
        $testimonialPhoto = 'testimonials/dummy.jpg';

        if (File::exists($sourceDummy)) {
            File::copy($sourceDummy, storage_path('app/public/' . $studentPhoto));
            File::copy($sourceDummy, storage_path('app/public/' . $alumniPhoto));
            File::copy($sourceDummy, storage_path('app/public/' . $structuralPhoto));
            File::copy($sourceDummy, storage_path('app/public/' . $testimonialPhoto));
            $this->command->info('Copied dummy profile images to public storage.');
        } else {
            // Write a small transparent pixel or placeholder
            $dummyContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=');
            Storage::disk('public')->put($studentPhoto, $dummyContent);
            Storage::disk('public')->put($alumniPhoto, $dummyContent);
            Storage::disk('public')->put($structuralPhoto, $dummyContent);
            Storage::disk('public')->put($testimonialPhoto, $dummyContent);
            $this->command->info('Created basic blank placeholders for profile images.');
        }

        // Fetch Kelas & Jurusan lists
        $kelasX = Common::where('table_name', 'kelas')->where('data1', 'X RPL 1')->first();
        $kelasXI = Common::where('table_name', 'kelas')->where('data1', 'XI RPL 1')->first();
        $kelasXII = Common::where('table_name', 'kelas')->where('data1', 'XII RPL 1')->first();

        $jurusanRpl = Common::where('table_name', 'jurusan')->where('data2', 'RPL')->first();
        $jurusanTjkt = Common::where('table_name', 'jurusan')->where('data2', 'TJKT')->first();
        $jurusanAkl = Common::where('table_name', 'jurusan')->where('data2', 'AKL')->first();

        // 1. Seed Students
        $students = [
            [
                'name' => 'Faisal Rahman',
                'nis' => '12021001',
                'nisn' => '0061234561',
                'photo' => $studentPhoto,
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '2008-04-12',
                'address' => 'Jl. Kebon Waru No. 12, Bandung',
                'phone' => '08987654321',
                'email' => 'faisal.r@gmail.com',
                'kelas_id' => $kelasXI ? $kelasXI->id : null,
                'jurusan_id' => $jurusanRpl ? $jurusanRpl->id : null,
                'order' => 1,
                'is_active' => true,
                'description' => "Ketua OSIS Periode 2024/2025\nJuara 1 Lomba Web Design Tingkat Kota Bandung 2024",
                'created_by' => $userId,
                'updated_by' => $userId,
            ],
            [
                'name' => 'Aura Nabila',
                'nis' => '12021002',
                'nisn' => '0061234562',
                'photo' => $studentPhoto,
                'gender' => 'female',
                'birth_place' => 'Cimahi',
                'birth_date' => '2007-09-21',
                'address' => 'Perum Permata Indah Blok C4, Cimahi',
                'phone' => '08987654322',
                'email' => 'aura.n@gmail.com',
                'kelas_id' => $kelasXII ? $kelasXII->id : null,
                'jurusan_id' => $jurusanRpl ? $jurusanRpl->id : null,
                'order' => 2,
                'is_active' => true,
                'description' => "Anggota Ekstrakurikuler Paskibra\nJuara Harapan 1 Lomba Pidato Bahasa Inggris 2024",
                'created_by' => $userId,
                'updated_by' => $userId,
            ],
            [
                'name' => 'Bintang Pratama',
                'nis' => '12021003',
                'nisn' => '0061234563',
                'photo' => $studentPhoto,
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '2009-01-15',
                'address' => 'Jl. Gatot Subroto No. 90, Bandung',
                'phone' => '08987654323',
                'email' => 'bintang.p@gmail.com',
                'kelas_id' => $kelasX ? $kelasX->id : null,
                'jurusan_id' => $jurusanTjkt ? $jurusanTjkt->id : null,
                'order' => 3,
                'is_active' => true,
                'description' => "Anggota Pramuka Penegak Bantara\nJuara 3 Lomba Jaringan Mikrotik Tingkat Provinsi 2025",
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        ];

        foreach ($students as $studentData) {
            Student::create($studentData);
        }

        // 2. Seed Alumni
        $alumni = [
            [
                'name' => 'Rian Hidayat, S.Kom.',
                'photo' => $alumniPhoto,
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '2002-05-18',
                'address' => 'Jl. Cibaduyut Lama No. 56, Bandung',
                'phone' => '081299998881',
                'email' => 'rian.h@gmail.com',
                'tahun_lulus' => '2020',
                'tempat_kerja' => 'PT Tokopedia',
                'jabatan' => 'Senior Frontend Developer',
                'status_alumni' => 'Bekerja',
                'bidang_pekerjaan' => 'Software Developer',
                'testimoni' => 'Belajar di SMK ini adalah pondasi terbaik karir saya. Kurikulum industri dan guru yang kompeten membuat saya siap kerja langsung setelah lulus.',
                'is_inspiratif' => true,
                'jurusan_id' => $jurusanRpl ? $jurusanRpl->id : null,
                'order' => 1,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'photo' => $alumniPhoto,
                'gender' => 'female',
                'birth_place' => 'Cimahi',
                'birth_date' => '2003-08-30',
                'address' => 'Jl. Cihanjuang No. 11, Cimahi',
                'phone' => '081299998882',
                'email' => 'siti.nh@gmail.com',
                'tahun_lulus' => '2021',
                'tempat_kerja' => 'Institut Teknologi Bandung',
                'jabatan' => 'Mahasiswa Teknik Informatika',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Berkat bekal ilmu pemrograman yang diajarkan, saya mendapat beasiswa penuh dan tidak kesulitan mengikuti perkuliahan di PTN ternama.',
                'is_inspiratif' => true,
                'jurusan_id' => $jurusanRpl ? $jurusanRpl->id : null,
                'order' => 2,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ],
            [
                'name' => 'Dimas Anggara',
                'photo' => $alumniPhoto,
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '2001-11-04',
                'address' => 'Jl. Sukajadi No. 190, Bandung',
                'phone' => '081299998883',
                'email' => 'dimas.a@gmail.com',
                'tahun_lulus' => '2019',
                'tempat_kerja' => 'PT Telkom Indonesia',
                'jabatan' => 'Network Administrator',
                'status_alumni' => 'Bekerja',
                'bidang_pekerjaan' => 'Network Engineer',
                'testimoni' => 'Kombinasi teori dan praktek laboratorium yang lengkap membuat proses sertifikasi keahlian saya berjalan sangat mulus ketika lulus.',
                'is_inspiratif' => false,
                'jurusan_id' => $jurusanTjkt ? $jurusanTjkt->id : null,
                'order' => 3,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        ];

        foreach ($alumni as $alumniData) {
            Alumni::create($alumniData);
        }

        // 3. Seed Structural Members
        $structural = [
            [
                'name' => 'Drs. H. Mulyana, M.Pd.',
                'photo' => $structuralPhoto,
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '1965-03-24',
                'address' => 'Jl. Dago Asri No. 10, Bandung',
                'phone' => '08112233445',
                'email' => 'mulyana@yayasan.org',
                'jabatan' => 'Ketua Yayasan Pendidikan',
                'order' => 1,
                'is_active' => true,
                'description' => 'Pendiri sekaligus pembina utama Yayasan Pendidikan yang menaungi sekolah.',
                'created_by' => $userId,
                'updated_by' => $userId,
            ],
            [
                'name' => 'Hj. Ratna Sari, S.E.',
                'photo' => $structuralPhoto,
                'gender' => 'female',
                'birth_place' => 'Jakarta',
                'birth_date' => '1972-07-12',
                'address' => 'Jl. Surya Sumantri No. 34, Bandung',
                'phone' => '08112233446',
                'email' => 'ratna.sari@yayasan.org',
                'jabatan' => 'Sekretaris Yayasan',
                'order' => 2,
                'is_active' => true,
                'description' => 'Mengawasi jalannya administrasi umum dan tata kelola organisasi yayasan.',
                'created_by' => $userId,
                'updated_by' => $userId,
            ],
            [
                'name' => 'H. Dedi Supriadi, M.M.',
                'photo' => $structuralPhoto,
                'gender' => 'male',
                'birth_place' => 'Sumedang',
                'birth_date' => '1968-10-09',
                'address' => 'Jl. Kiara Condong No. 112, Bandung',
                'phone' => '08112233447',
                'email' => 'dedi.s@yayasan.org',
                'jabatan' => 'Bendahara Yayasan',
                'order' => 3,
                'is_active' => true,
                'description' => 'Mengatur keuangan serta memantau investasi pembangunan fasilitas fisik sekolah.',
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        ];

        foreach ($structural as $memberData) {
            StructuralMember::create($memberData);
        }

        // 4. Seed Testimonials
        $testimonials = [
            [
                'name' => 'Ir. Gunawan Wibisono',
                'role' => 'Direktur HRD PT Inovasi Teknologi',
                'photo' => $testimonialPhoto,
                'rating' => 5,
                'content' => 'Lulusan dari SMK ini memiliki etos kerja yang sangat baik dan langsung siap diterjunkan dalam proyek nyata tanpa membutuhkan training yang lama.',
                'order' => 1,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ],
            [
                'name' => 'Prof. Dr. Hermawan Kartajaya',
                'role' => 'Dosen Pembimbing Akademik ITB',
                'photo' => $testimonialPhoto,
                'rating' => 5,
                'content' => 'Mahasiswa lepasan sekolah ini yang melanjutkan studi di kampus kami menunjukkan prestasi akademik yang menonjol dan kepemimpinan yang matang di organisasi.',
                'order' => 2,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ],
            [
                'name' => 'Rahmat Hidayat',
                'role' => 'Orang Tua Siswa (Kelas XII RPL)',
                'photo' => null,
                'rating' => 4,
                'content' => 'Sangat bersyukur menyekolahkan anak saya di sini. Fasilitasnya lengkap, pembinaan akhlaknya baik, dan anak saya sudah diterima bekerja sebelum kelulusan.',
                'order' => 3,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::create($testimonialData);
        }

        $this->command->info('✅ SDM & Testimonial data seeded successfully!');
    }
}
