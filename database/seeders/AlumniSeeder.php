<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get creator
        $user = User::first();
        $userId = $user ? $user->id : 1;

        $this->command->info('Truncating alumni table and preparing seeds...');
        
        // Truncate table to ensure exactly 15 records
        Alumni::truncate();

        // Ensure directory exists
        Storage::disk('public')->makeDirectory('alumni');

        // Copy dummy avatars for premium visuals
        $avatars = [];
        for ($i = 1; $i <= 10; $i++) {
            $num = sprintf('%02d', $i);
            $src = public_path("assets/site/images/testimonial/client-{$num}.png");
            $dest = "alumni/alumni-{$num}.png";
            if (File::exists($src)) {
                File::copy($src, storage_path('app/public/' . $dest));
                $avatars[$i] = $dest;
            } else {
                $avatars[$i] = 'alumni/dummy.jpg';
            }
        }
        
        // If dummy.jpg doesn't exist, create it
        $dummyDest = storage_path('app/public/alumni/dummy.jpg');
        if (!File::exists($dummyDest)) {
            $sourceDummy = public_path('assets/admin/images/users/user-dummy-img.jpg');
            if (File::exists($sourceDummy)) {
                File::copy($sourceDummy, $dummyDest);
            } else {
                $dummyContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=');
                Storage::disk('public')->put('alumni/dummy.jpg', $dummyContent);
            }
        }

        // Get programs
        $programs = Program::get()->keyBy('kode');
        $getRplId = isset($programs['RPL']) ? $programs['RPL']->id : null;
        $getTjktId = isset($programs['TJKT']) ? $programs['TJKT']->id : null;
        $getAklId = isset($programs['AKL']) ? $programs['AKL']->id : null;

        // 10 Kuliah Alumni
        $kuliahAlumni = [
            [
                'name' => 'Ahmad Fauzi',
                'photo' => $avatars[1] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '2004-03-12',
                'address' => 'Jl. Merdeka No. 45, Bandung',
                'phone' => '081234567801',
                'email' => 'ahmad.fauzi@gmail.com',
                'tahun_lulus' => '2022',
                'tempat_kerja' => 'Institut Teknologi Bandung (ITB)',
                'jabatan' => 'Mahasiswa Teknik Informatika',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Bekal materi pemrograman web dan basis data dari SMK sangat menunjang kuliah saya. Di semester awal ITB saya merasa jauh lebih siap dibanding rekan-rekan lulusan SMA.',
                'is_inspiratif' => true,
                'jurusan_id' => $getRplId,
            ],
            [
                'name' => 'Luthfi Ramadhan',
                'photo' => $avatars[2] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Jakarta',
                'birth_date' => '2005-07-22',
                'address' => 'Jl. Gatot Subroto No. 12, Bandung',
                'phone' => '081234567802',
                'email' => 'luthfi.r@gmail.com',
                'tahun_lulus' => '2023',
                'tempat_kerja' => 'Universitas Indonesia (UI)',
                'jabatan' => 'Mahasiswa Ilmu Komputer',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Kurikulum di sekolah yang adaptif dan fokus pada project base learning sangat melatih logika berpikir saya untuk mata kuliah Algoritma dan Pemrograman di UI.',
                'is_inspiratif' => true,
                'jurusan_id' => $getRplId,
            ],
            [
                'name' => 'Siti Aminah',
                'photo' => $avatars[3] ?? 'alumni/dummy.jpg',
                'gender' => 'female',
                'birth_place' => 'Cimahi',
                'birth_date' => '2004-11-05',
                'address' => 'Jl. Cihanjuang No. 88, Cimahi',
                'phone' => '081234567803',
                'email' => 'siti.aminah@gmail.com',
                'tahun_lulus' => '2022',
                'tempat_kerja' => 'Universitas Gadjah Mada (UGM)',
                'jabatan' => 'Mahasiswa Teknologi Informasi',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Fasilitas laboratorium komputer dan praktek jaringan selama sekolah membuka wawasan saya tentang arsitektur internet modern, sangat berguna dalam perkuliahan di UGM.',
                'is_inspiratif' => true,
                'jurusan_id' => $getTjktId,
            ],
            [
                'name' => 'Rizky Pratama',
                'photo' => $avatars[4] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Soreang',
                'birth_date' => '2003-09-18',
                'address' => 'Perum Indah Regency No. A4, Bandung',
                'phone' => '081234567804',
                'email' => 'rizky.p@gmail.com',
                'tahun_lulus' => '2021',
                'tempat_kerja' => 'Universitas Padjadjaran (Unpad)',
                'jabatan' => 'Mahasiswa Akuntansi Keuangan',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Praktek komputer akuntansi menggunakan Accurate dan MYOB selama di sekolah membuat mata kuliah Akuntansi Praktis di Unpad terasa jauh lebih mudah dipahami.',
                'is_inspiratif' => false,
                'jurusan_id' => $getAklId,
            ],
            [
                'name' => 'Fatimah Az-Zahra',
                'photo' => $avatars[5] ?? 'alumni/dummy.jpg',
                'gender' => 'female',
                'birth_place' => 'Bandung',
                'birth_date' => '2005-01-30',
                'address' => 'Jl. Antapani No. 102, Bandung',
                'phone' => '081234567805',
                'email' => 'fatimah.az@gmail.com',
                'tahun_lulus' => '2023',
                'tempat_kerja' => 'Universitas Pendidikan Indonesia (UPI)',
                'jabatan' => 'Mahasiswa Pendidikan Ilmu Komputer',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Sekolah melatih mental dan kedisiplinan saya. Para guru tidak hanya memberikan ilmu akademis tetapi juga etika kepemimpinan yang luar biasa.',
                'is_inspiratif' => false,
                'jurusan_id' => $getRplId,
            ],
            [
                'name' => 'Budi Santoso',
                'photo' => $avatars[6] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Sumedang',
                'birth_date' => '2004-05-14',
                'address' => 'Jl. Jatinangor No. 27, Sumedang',
                'phone' => '081234567806',
                'email' => 'budi.s@gmail.com',
                'tahun_lulus' => '2022',
                'tempat_kerja' => 'Telkom University',
                'jabatan' => 'Mahasiswa Teknik Telekomunikasi',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Pengalaman praktek konfigurasi routing, Cisco, dan Mikrotik di laboratorium sekolah memberikan dasar yang sangat kuat bagi mata kuliah jaringan telekomunikasi saya.',
                'is_inspiratif' => true,
                'jurusan_id' => $getTjktId,
            ],
            [
                'name' => 'Dewi Lestari',
                'photo' => $avatars[7] ?? 'alumni/dummy.jpg',
                'gender' => 'female',
                'birth_place' => 'Bandung',
                'birth_date' => '2004-08-09',
                'address' => 'Jl. Pasir Kaliki No. 15, Bandung',
                'phone' => '081234567807',
                'email' => 'dewi.lestari@gmail.com',
                'tahun_lulus' => '2022',
                'tempat_kerja' => 'Universitas Diponegoro (Undip)',
                'jabatan' => 'Mahasiswa Manajemen Keuangan',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Berkat pembekalan perpajakan dan audit dari sekolah, saya bisa berprestasi dalam kompetisi akuntansi nasional tingkat universitas semester ini.',
                'is_inspiratif' => false,
                'jurusan_id' => $getAklId,
            ],
            [
                'name' => 'Eko Prasetyo',
                'photo' => $avatars[8] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Garut',
                'birth_date' => '2003-12-25',
                'address' => 'Jl. Soekarno Hatta No. 345, Bandung',
                'phone' => '081234567808',
                'email' => 'eko.p@gmail.com',
                'tahun_lulus' => '2021',
                'tempat_kerja' => 'Institut Teknologi Sepuluh Nopember (ITS)',
                'jabatan' => 'Mahasiswa Sistem Informasi',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Pelajaran rekayasa perangkat lunak mengajarkan saya esensi dari Software Development Life Cycle (SDLC) yang sangat ditekankan di perkuliahan ITS.',
                'is_inspiratif' => false,
                'jurusan_id' => $getRplId,
            ],
            [
                'name' => 'Indah Cahyani',
                'photo' => $avatars[9] ?? 'alumni/dummy.jpg',
                'gender' => 'female',
                'birth_place' => 'Bandung',
                'birth_date' => '2005-04-12',
                'address' => 'Jl. Buah Batu No. 199, Bandung',
                'phone' => '081234567809',
                'email' => 'indah.c@gmail.com',
                'tahun_lulus' => '2023',
                'tempat_kerja' => 'BINUS University',
                'jabatan' => 'Mahasiswa Mobile Application Development',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Materi Android programming and OOP yang solid selama sekolah membuat saya langsung terpilih menjadi asisten laboratorium di BINUS.',
                'is_inspiratif' => false,
                'jurusan_id' => $getRplId,
            ],
            [
                'name' => 'Fajar Nugraha',
                'photo' => $avatars[10] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Subang',
                'birth_date' => '2004-10-02',
                'address' => 'Jl. Dago Elos No. 3, Bandung',
                'phone' => '081234567810',
                'email' => 'fajar.n@gmail.com',
                'tahun_lulus' => '2022',
                'tempat_kerja' => 'Universitas Brawijaya (UB)',
                'jabatan' => 'Mahasiswa Jaringan Komputer',
                'status_alumni' => 'Kuliah',
                'bidang_pekerjaan' => null,
                'testimoni' => 'Sertifikasi industri CCNA yang difasilitasi sekolah saat kelas XI benar-benar mempercepat pemahaman materi infrastruktur IT saya di UB.',
                'is_inspiratif' => true,
                'jurusan_id' => $getTjktId,
            ],
        ];

        // 5 Bekerja Alumni
        $bekerjaAlumni = [
            [
                'name' => 'Rian Hidayat, S.Kom.',
                'photo' => $avatars[1] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '2000-05-18',
                'address' => 'Jl. Cibaduyut Lama No. 56, Bandung',
                'phone' => '081299998881',
                'email' => 'rian.h@gmail.com',
                'tahun_lulus' => '2019',
                'tempat_kerja' => 'PT Tokopedia (GoTo)',
                'jabatan' => 'Senior Frontend Developer',
                'status_alumni' => 'Bekerja',
                'bidang_pekerjaan' => 'Software Engineering',
                'testimoni' => 'Belajar di SMK ini adalah pondasi terbaik karir saya. Kurikulum industri dan guru yang kompeten membuat saya siap kerja langsung setelah lulus.',
                'is_inspiratif' => true,
                'jurusan_id' => $getRplId,
            ],
            [
                'name' => 'Dimas Anggara',
                'photo' => $avatars[2] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '1999-11-04',
                'address' => 'Jl. Sukajadi No. 190, Bandung',
                'phone' => '081299998883',
                'email' => 'dimas.a@gmail.com',
                'tahun_lulus' => '2018',
                'tempat_kerja' => 'PT Telkom Indonesia',
                'jabatan' => 'Network Security Specialist',
                'status_alumni' => 'Bekerja',
                'bidang_pekerjaan' => 'Cyber Security / IT',
                'testimoni' => 'Kombinasi teori and praktek laboratorium yang lengkap membuat proses sertifikasi keahlian saya berjalan sangat mulus ketika lulus.',
                'is_inspiratif' => true,
                'jurusan_id' => $getTjktId,
            ],
            [
                'name' => 'Andika Wijaya',
                'photo' => $avatars[3] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Cimahi',
                'birth_date' => '2001-02-15',
                'address' => 'Jl. Leuwigajah No. 45, Cimahi',
                'phone' => '081234567811',
                'email' => 'andika.w@gmail.com',
                'tahun_lulus' => '2020',
                'tempat_kerja' => 'Shopee Indonesia',
                'jabatan' => 'Fullstack Web Engineer',
                'status_alumni' => 'Bekerja',
                'bidang_pekerjaan' => 'Software Developer',
                'testimoni' => 'Tugas akhir berbasis project yang menantang selama sekolah sangat membantu portofolio saya untuk menembus seleksi kerja di e-commerce ternama.',
                'is_inspiratif' => true,
                'jurusan_id' => $getRplId,
            ],
            [
                'name' => 'Riana Fitriani',
                'photo' => $avatars[4] ?? 'alumni/dummy.jpg',
                'gender' => 'female',
                'birth_place' => 'Bandung',
                'birth_date' => '2002-06-21',
                'address' => 'Jl. Kopo Sayati No. 12, Bandung',
                'phone' => '081234567812',
                'email' => 'riana.f@gmail.com',
                'tahun_lulus' => '2020',
                'tempat_kerja' => 'PricewaterhouseCoopers (PwC) Indonesia',
                'jabatan' => 'Junior Auditor',
                'status_alumni' => 'Bekerja',
                'bidang_pekerjaan' => 'Akuntansi / Auditor',
                'testimoni' => 'Kemampuan audit dan analisis laporan keuangan yang diajarkan guru sangat relevan dengan standar kerja KAP Big Four tempat saya berkarir.',
                'is_inspiratif' => true,
                'jurusan_id' => $getAklId,
            ],
            [
                'name' => 'Maulana Malik',
                'photo' => $avatars[5] ?? 'alumni/dummy.jpg',
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '2000-08-31',
                'address' => 'Jl. Gedebage No. 90, Bandung',
                'phone' => '081234567813',
                'email' => 'maulana.m@gmail.com',
                'tahun_lulus' => '2019',
                'tempat_kerja' => 'PT Astra International Tbk',
                'jabatan' => 'Systems Administrator',
                'status_alumni' => 'Bekerja',
                'bidang_pekerjaan' => 'IT Operations',
                'testimoni' => 'Sekolah tidak hanya mengajarkan skill teknis, tetapi soft skill seperti kedisiplinan dan komunikasi kerja (attitude) yang sangat dihargai di Astra.',
                'is_inspiratif' => false,
                'jurusan_id' => $getTjktId,
            ],
        ];

        // Seed Kuliah Alumni
        $order = 1;
        foreach ($kuliahAlumni as $data) {
            Alumni::create(array_merge($data, [
                'order' => $order++,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]));
        }

        // Seed Bekerja Alumni
        foreach ($bekerjaAlumni as $data) {
            Alumni::create(array_merge($data, [
                'order' => $order++,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]));
        }

        $this->command->info('Successfully seeded exactly 15 alumni!');
    }
}
