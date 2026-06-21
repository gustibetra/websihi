<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Services\CommonIdGeneratorService;

class CommonDataSeeder extends Seeder
{
    public function run(): void
    {
        $idGen = app(CommonIdGeneratorService::class);
        $userId = 1;

        // =============================================
        // 1. Jurusan (Program Keahlian)
        // =============================================
        $jurusans = [
            ['nama' => 'Rekayasa Perangkat Lunak', 'kode' => 'RPL', 'kepala' => 'Budi Santoso, S.Kom', 'akreditasi' => 'A'],
            ['nama' => 'Teknik Jaringan Komputer dan Telekomunikasi', 'kode' => 'TJKT', 'kepala' => 'Ahmad Rizal, S.T', 'akreditasi' => 'A'],
            ['nama' => 'Akuntansi dan Keuangan Lembaga', 'kode' => 'AKL', 'kepala' => 'Siti Aminah, S.E', 'akreditasi' => 'B'],
        ];

        $jurusanIds = [];
        foreach ($jurusans as $jur) {
            $existing = DB::table('common')->where('table_name', 'jurusan')->where('data2', $jur['kode'])->first();
            if ($existing) {
                $jurusanIds[$jur['kode']] = $existing->id;
                continue;
            }
            $id = DB::table('common')->insertGetId([
                'table_name' => 'jurusan',
                'key1'       => $idGen->generateId('jurusan'),
                'data1'      => $jur['nama'],
                'data2'      => $jur['kode'],
                'data3'      => $jur['kepala'],
                'data4'      => $jur['akreditasi'],
                'text1'      => 'Deskripsi jurusan ' . $jur['nama'],
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $jurusanIds[$jur['kode']] = $id;
        }

        // =============================================
        // 2. Tahun Ajaran / Periode
        // =============================================
        $periods = [
            ['nama' => 'Tahun Ajaran 2023/2024', 'start' => '2023-07-15', 'end' => '2024-06-15', 'current' => '0'],
            ['nama' => 'Tahun Ajaran 2024/2025', 'start' => '2024-07-15', 'end' => '2025-06-15', 'current' => '0'],
            ['nama' => 'Tahun Ajaran 2025/2026', 'start' => '2025-07-15', 'end' => '2026-06-15', 'current' => '1'],
            ['nama' => 'Periode OSIS 2024/2025',  'start' => '2024-07-01', 'end' => '2025-06-30', 'current' => '0'],
        ];

        $periodIds = [];
        foreach ($periods as $p) {
            $existing = DB::table('common')->where('table_name', 'period')->where('data1', $p['nama'])->first();
            if ($existing) { $periodIds[] = $existing->id; continue; }
            $id = DB::table('common')->insertGetId([
                'table_name' => 'period',
                'key1'       => $idGen->generateId('period'),
                'data1'      => $p['nama'],
                'date1'      => $p['start'],
                'date2'      => $p['end'],
                'data4'      => $p['current'],
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $periodIds[] = $id;
        }

        // =============================================
        // 3. Tingkat Kelas (BARU)
        // =============================================
        $tingkatKelas = [
            ['nama' => 'Kelas X',   'urutan' => 1],
            ['nama' => 'Kelas XI',  'urutan' => 2],
            ['nama' => 'Kelas XII', 'urutan' => 3],
        ];

        $tingkatIds = [];
        foreach ($tingkatKelas as $tk) {
            $existing = DB::table('common')->where('table_name', 'tingkat_kelas')->where('data1', $tk['nama'])->first();
            if ($existing) { $tingkatIds[$tk['nama']] = $existing->id; continue; }
            $id = DB::table('common')->insertGetId([
                'table_name' => 'tingkat_kelas',
                'key1'       => $idGen->generateId('tingkat_kelas'),
                'data1'      => $tk['nama'],
                'data2'      => $tk['urutan'], // untuk sorting
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $tingkatIds[$tk['nama']] = $id;
        }

        // =============================================
        // 4. Kelas / Rombel (update: data2=tingkat_id, data3=jurusan_id)
        // =============================================
        $kelasData = [
            ['nama' => 'X RPL 1',  'tingkat' => 'Kelas X',   'jurusan' => 'RPL'],
            ['nama' => 'X RPL 2',  'tingkat' => 'Kelas X',   'jurusan' => 'RPL'],
            ['nama' => 'XI RPL 1', 'tingkat' => 'Kelas XI',  'jurusan' => 'RPL'],
            ['nama' => 'XII RPL 1','tingkat' => 'Kelas XII', 'jurusan' => 'RPL'],
            ['nama' => 'X TJKT 1', 'tingkat' => 'Kelas X',   'jurusan' => 'TJKT'],
            ['nama' => 'XI TJKT 1','tingkat' => 'Kelas XI',  'jurusan' => 'TJKT'],
            ['nama' => 'X AKL 1',  'tingkat' => 'Kelas X',   'jurusan' => 'AKL'],
        ];

        foreach ($kelasData as $k) {
            $existing = DB::table('common')->where('table_name', 'kelas')->where('data1', $k['nama'])->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'kelas',
                'key1'       => $idGen->generateId('kelas'),
                'data1'      => $k['nama'],
                'data2'      => $tingkatIds[$k['tingkat']] ?? null, // relasi tingkat
                'data3'      => $jurusanIds[$k['jurusan']] ?? null, // relasi jurusan
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 5. Kompetensi Keahlian (BARU) — berelasi ke Jurusan
        // =============================================
        $kompetensi = [
            // RPL
            ['nama' => 'Pemrograman Web',       'jurusan' => 'RPL'],
            ['nama' => 'Pemrograman Mobile',     'jurusan' => 'RPL'],
            ['nama' => 'Basis Data',             'jurusan' => 'RPL'],
            ['nama' => 'UI/UX Design',           'jurusan' => 'RPL'],
            ['nama' => 'Software Testing',       'jurusan' => 'RPL'],
            // TJKT
            ['nama' => 'Administrasi Sistem Jaringan', 'jurusan' => 'TJKT'],
            ['nama' => 'Routing & Switching',    'jurusan' => 'TJKT'],
            ['nama' => 'Cloud Computing',        'jurusan' => 'TJKT'],
            ['nama' => 'Fiber Optik',            'jurusan' => 'TJKT'],
            // AKL
            ['nama' => 'Akuntansi Keuangan',     'jurusan' => 'AKL'],
            ['nama' => 'Perpajakan',              'jurusan' => 'AKL'],
        ];

        foreach ($kompetensi as $k) {
            $existing = DB::table('common')->where('table_name', 'kompetensi_keahlian')->where('data1', $k['nama'])->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'kompetensi_keahlian',
                'key1'       => $idGen->generateId('kompetensi_keahlian'),
                'data1'      => $k['nama'],
                'data2'      => $jurusanIds[$k['jurusan']] ?? null, // relasi jurusan
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 6. Kurikulum (BARU)
        // =============================================
        $kurikulums = [
            ['nama' => 'Kurikulum Merdeka', 'tahun' => '2022'],
            ['nama' => 'Kurikulum 2013 (Revisi)', 'tahun' => '2013'],
            ['nama' => 'Kurikulum Industri', 'tahun' => '2023'],
            ['nama' => 'Teaching Factory', 'tahun' => '2023'],
        ];

        foreach ($kurikulums as $k) {
            $existing = DB::table('common')->where('table_name', 'kurikulum')->where('data1', $k['nama'])->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'kurikulum',
                'key1'       => $idGen->generateId('kurikulum'),
                'data1'      => $k['nama'],
                'data4'      => $k['tahun'],
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 7. Struktur Organisasi (Existing — skip if exists)
        // =============================================
        $structures = [
            ['nama' => 'Manajemen Sekolah',  'type' => 'sekolah',    'jurusan' => null],
            ['nama' => 'Komite Sekolah',     'type' => 'sekolah',    'jurusan' => null],
            ['nama' => 'OSIS 2024/2025',     'type' => 'organisasi', 'jurusan' => null],
            ['nama' => 'MPK 2024/2025',      'type' => 'organisasi', 'jurusan' => null],
            ['nama' => 'Pramuka',            'type' => 'ekskul',     'jurusan' => null],
            ['nama' => 'PMR',                'type' => 'ekskul',     'jurusan' => null],
            ['nama' => 'Paskibra',           'type' => 'ekskul',     'jurusan' => null],
            ['nama' => 'IT Club',            'type' => 'ekskul',     'jurusan' => 'RPL'],
            ['nama' => 'Panitia MPLS 2025',  'type' => 'kepanitiaan','jurusan' => null],
            ['nama' => 'Panitia Wisuda 2025','type' => 'kepanitiaan','jurusan' => null],
        ];

        $activePeriodId = $periodIds[2] ?? ($periodIds[0] ?? null);
        foreach ($structures as $s) {
            $existing = DB::table('common')->where('table_name', 'structure')->where('data1', $s['nama'])->where('key2', $s['type'])->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'structure',
                'key1'       => $idGen->generateId('structure', $s['type']),
                'key2'       => $s['type'],
                'data1'      => $s['nama'],
                'data2'      => $activePeriodId,
                'data3'      => $s['jurusan'] ? ($jurusanIds[$s['jurusan']] ?? null) : null,
                'data5'      => $s['type'],
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 8. Jabatan Organisasi (Existing)
        // =============================================
        $jabatans = [
            'Kepala Sekolah', 'Wakasek Kurikulum', 'Wakasek Kesiswaan',
            'Kaprog / Kaprodi', 'Pembina', 'Pelatih',
            'Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara',
            'Koordinator', 'Anggota',
        ];
        foreach ($jabatans as $jab) {
            $existing = DB::table('common')->where('table_name', 'jabatan_organisasi')->where('data1', $jab)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'jabatan_organisasi',
                'key1'       => $idGen->generateId('jabatan_organisasi'),
                'data1'      => $jab,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 9. Seksi Bidang / Divisi (Existing + Tambahan)
        // =============================================
        $divisis = [
            'Humas', 'Kesiswaan', 'Kurikulum', 'Sarpras', 'Hubin', 'BKK', 'BK',
            'Sekbid Ketakwaan', 'Sekbid Olahraga', 'Sekbid Kesenian',
            'Divisi Acara', 'Divisi Konsumsi', 'Divisi Perlengkapan', 'Divisi Dokumentasi',
        ];
        foreach ($divisis as $div) {
            $existing = DB::table('common')->where('table_name', 'divisi')->where('data1', $div)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'divisi',
                'key1'       => $idGen->generateId('divisi'),
                'data1'      => $div,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // =============================================
        // 10. Jenis Kerjasama (BARU)
        // =============================================
        $jenisKerjasama = [
            'PKL (Praktik Kerja Lapangan)', 'Teaching Factory', 'Kelas Industri',
            'Rekrutmen Alumni', 'Guru Tamu', 'Sinkronisasi Kurikulum',
            'Sertifikasi Kompetensi', 'Kunjungan Industri', 'Magang Guru',
        ];
        $jkIds = [];
        foreach ($jenisKerjasama as $jk) {
            $existing = DB::table('common')->where('table_name', 'jenis_kerjasama')->where('data1', $jk)->first();
            if ($existing) {
                $jkIds[] = $existing->id;
                continue;
            }
            $id = DB::table('common')->insertGetId([
                'table_name' => 'jenis_kerjasama',
                'key1'       => $idGen->generateId('jenis_kerjasama'),
                'data1'      => $jk,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $jkIds[] = $id;
        }

        // =============================================
        // 11. Mitra Industri (Existing + Lengkap)
        // =============================================
        $mitras = [
            ['nama' => 'PT. Telkom Indonesia',     'bidang' => 'Telekomunikasi',      'web' => 'https://telkom.co.id',  'kontak' => '021-5001111', 'jks' => [0, 2, 4]],
            ['nama' => 'PT. Astra International',  'bidang' => 'Otomotif & Teknologi','web' => 'https://astra.co.id',   'kontak' => '021-6522555', 'jks' => [0, 3]],
            ['nama' => 'PT. Toyota Motor Mfg.',    'bidang' => 'Manufaktur Otomotif', 'web' => 'https://toyota.co.id',  'kontak' => '021-8836000', 'jks' => [1, 2]],
            ['nama' => 'CV. Media Nusantara',      'bidang' => 'Software House',      'web' => 'https://example.com',   'kontak' => '022-1234567', 'jks' => [0, 3, 5]],
            ['nama' => 'PT. Indomarco Prismatama', 'bidang' => 'Retail',              'web' => 'https://indomaret.co.id','kontak' => '021-7590999', 'jks' => [3]],
        ];
        foreach ($mitras as $m) {
            $associatedJks = [];
            foreach ($m['jks'] as $idx) {
                if (isset($jkIds[$idx])) {
                    $associatedJks[] = $jkIds[$idx];
                }
            }
            $data6Val = implode(';', $associatedJks);

            $existing = DB::table('common')->where('table_name', 'mitra_industri')->where('data1', $m['nama'])->first();
            if ($existing) {
                DB::table('common')->where('id', $existing->id)->update([
                    'data6' => $data6Val,
                    'updated_at' => now(),
                ]);
                continue;
            }
            DB::table('common')->insert([
                'table_name' => 'mitra_industri',
                'key1'       => $idGen->generateId('mitra_industri'),
                'data1'      => $m['nama'],
                'data4'      => $m['bidang'],
                'data2'      => $m['web'],
                'data5'      => $m['kontak'],
                'data6'      => $data6Val,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 12. Bidang Industri (BARU)
        // =============================================
        $bidangIndustri = [
            'Teknologi Informasi', 'Software House', 'Telekomunikasi',
            'Manufaktur', 'Otomotif', 'Perbankan', 'Retail',
            'Digital Marketing', 'Kuliner & F&B', 'Hospitality & Pariwisata',
            'Konstruksi', 'Kesehatan & Farmasi', 'Pendidikan',
        ];
        foreach ($bidangIndustri as $bi) {
            $existing = DB::table('common')->where('table_name', 'bidang_industri')->where('data1', $bi)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'bidang_industri',
                'key1'       => $idGen->generateId('bidang_industri'),
                'data1'      => $bi,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 13. Fasilitas Sekolah (Existing)
        // =============================================
        $fasilitas = [
            ['nama' => 'Laboratorium Komputer RPL', 'lokasi' => 'Gedung B Lt 2', 'kapasitas' => '36 Siswa'],
            ['nama' => 'Laboratorium Jaringan TJKT','lokasi' => 'Gedung B Lt 1', 'kapasitas' => '30 Siswa'],
            ['nama' => 'Perpustakaan',               'lokasi' => 'Gedung A Lt 1', 'kapasitas' => '100 Orang'],
            ['nama' => 'Masjid Sekolah',             'lokasi' => 'Area Tengah',   'kapasitas' => '500 Jamaah'],
            ['nama' => 'Lapangan Olahraga',          'lokasi' => 'Belakang Gedung','kapasitas' => '-'],
            ['nama' => 'Aula Serbaguna',             'lokasi' => 'Gedung C',       'kapasitas' => '300 Orang'],
        ];
        foreach ($fasilitas as $f) {
            $existing = DB::table('common')->where('table_name', 'fasilitas')->where('data1', $f['nama'])->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'fasilitas',
                'key1'       => $idGen->generateId('fasilitas'),
                'data1'      => $f['nama'],
                'data2'      => $f['lokasi'],
                'data4'      => $f['kapasitas'],
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 14. Sertifikasi (BARU)
        // =============================================
        $sertifikasi = [
            ['nama' => 'BNSP - Teknik Jaringan Komputer', 'lembaga' => 'BNSP'],
            ['nama' => 'Mikrotik MTCNA',                  'lembaga' => 'Mikrotik'],
            ['nama' => 'Cisco IT Essentials',             'lembaga' => 'Cisco Networking Academy'],
            ['nama' => 'Cisco CCNA',                      'lembaga' => 'Cisco Networking Academy'],
            ['nama' => 'MOS (Microsoft Office Specialist)','lembaga' => 'Microsoft'],
            ['nama' => 'AWS Academy Cloud Foundations',   'lembaga' => 'Amazon Web Services'],
            ['nama' => 'Adobe Certified Professional',    'lembaga' => 'Adobe'],
            ['nama' => 'TOEIC',                           'lembaga' => 'ETS'],
        ];
        foreach ($sertifikasi as $s) {
            $existing = DB::table('common')->where('table_name', 'sertifikasi')->where('data1', $s['nama'])->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'sertifikasi',
                'key1'       => $idGen->generateId('sertifikasi'),
                'data1'      => $s['nama'],
                'data4'      => $s['lembaga'],
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 15. Program Unggulan (BARU)
        // =============================================
        $programs = [
            ['nama' => 'Teaching Factory',    'kategori' => 'Akademik'],
            ['nama' => 'Kelas Industri',       'kategori' => 'Kerjasama Industri'],
            ['nama' => 'Smart School',         'kategori' => 'Teknologi'],
            ['nama' => 'Kelas Coding',         'kategori' => 'Teknologi'],
            ['nama' => 'Inkubator Bisnis',     'kategori' => 'Kewirausahaan'],
            ['nama' => 'Kelas Bahasa Jepang',  'kategori' => 'Bahasa'],
        ];
        foreach ($programs as $p) {
            $existing = DB::table('common')->where('table_name', 'program_unggulan')->where('data1', $p['nama'])->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'program_unggulan',
                'key1'       => $idGen->generateId('program_unggulan'),
                'data1'      => $p['nama'],
                'data4'      => $p['kategori'],
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 16. Kategori Prestasi (BARU)
        // =============================================
        $kategoriPrestasi = ['Akademik', 'Non Akademik', 'Kejuruan', 'Olahraga', 'Seni dan Budaya', 'Organisasi', 'Literasi'];
        foreach ($kategoriPrestasi as $kp) {
            $existing = DB::table('common')->where('table_name', 'kategori_prestasi')->where('data1', $kp)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'kategori_prestasi',
                'key1'       => $idGen->generateId('kategori_prestasi'),
                'data1'      => $kp,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 17. Tingkatan Prestasi (BARU)
        // =============================================
        $tingkatanPrestasi = [
            'Internal Sekolah', 'Antar Kelas', 'Antar Sekolah',
            'Kecamatan', 'Kabupaten / Kota', 'Wilayah / Regional',
            'Provinsi', 'Nasional', 'Asia Tenggara', 'Asia', 'Internasional',
        ];
        foreach ($tingkatanPrestasi as $tp) {
            $existing = DB::table('common')->where('table_name', 'tingkatan_prestasi')->where('data1', $tp)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'tingkatan_prestasi',
                'key1'       => $idGen->generateId('tingkatan_prestasi'),
                'data1'      => $tp,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 18. Status Alumni (BARU)
        // =============================================
        $statusAlumni = ['Bekerja', 'Kuliah', 'Wirausaha', 'Bekerja dan Kuliah', 'Mengikuti Pelatihan', 'Mencari Kerja', 'Belum Terdata'];
        foreach ($statusAlumni as $sa) {
            $existing = DB::table('common')->where('table_name', 'status_alumni')->where('data1', $sa)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'status_alumni',
                'key1'       => $idGen->generateId('status_alumni'),
                'data1'      => $sa,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 19. Bidang Pekerjaan (BARU)
        // =============================================
        $bidangPekerjaan = [
            'Software Developer', 'Web Developer', 'Mobile Developer',
            'Network Engineer', 'IT Support', 'UI/UX Designer', 'Graphic Designer',
            'Digital Marketing', 'Akuntan', 'Staff Administrasi',
            'Operator Produksi', 'Quality Control', 'Teknisi Otomotif',
            'Guru / Pendidik', 'Wirausaha / Entrepreneur', 'Freelancer',
        ];
        foreach ($bidangPekerjaan as $bp) {
            $existing = DB::table('common')->where('table_name', 'bidang_pekerjaan')->where('data1', $bp)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'bidang_pekerjaan',
                'key1'       => $idGen->generateId('bidang_pekerjaan'),
                'data1'      => $bp,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 20. Kategori Berita (Existing)
        // =============================================
        $kategoriBerita = ['Berita Sekolah', 'Prestasi', 'Akademik', 'Kegiatan', 'Pengumuman', 'Hubungan Industri'];
        foreach ($kategoriBerita as $kb) {
            $existing = DB::table('common')->where('table_name', 'kategori_berita')->where('data1', $kb)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'kategori_berita',
                'key1'       => $idGen->generateId('kategori_berita'),
                'data1'      => $kb,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 21. Kategori Event (Existing)
        // =============================================
        $kategoriEvent = ['Seminar', 'Workshop', 'Lomba / Kompetisi', 'Pelatihan', 'Kunjungan Industri', 'Pameran'];
        foreach ($kategoriEvent as $ke) {
            $existing = DB::table('common')->where('table_name', 'kategori_event')->where('data1', $ke)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'kategori_event',
                'key1'       => $idGen->generateId('kategori_event'),
                'data1'      => $ke,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 22. Kategori Pengumuman
        // =============================================
        $kategoriPengumuman = ['Akademik', 'Kesiswaan', 'Kelulusan', 'PPDB', 'Libur Sekolah', 'Beasiswa'];
        foreach ($kategoriPengumuman as $kp) {
            $existing = DB::table('common')->where('table_name', 'kategori_pengumuman')->where('data1', $kp)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'kategori_pengumuman',
                'key1'       => $idGen->generateId('kategori_pengumuman'),
                'data1'      => $kp,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 23. Kategori Galeri
        // =============================================
        $kategoriGaleri = ['Kegiatan Sekolah', 'Prestasi', 'PKL', 'Workshop', 'Lomba', 'Wisuda', 'MPLS'];
        foreach ($kategoriGaleri as $kg) {
            $existing = DB::table('common')->where('table_name', 'kategori_galeri')->where('data1', $kg)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'kategori_galeri',
                'key1'       => $idGen->generateId('kategori_galeri'),
                'data1'      => $kg,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 24. Kategori Download
        // =============================================
        $kategoriDownload = ['Formulir', 'Brosur & Leaflet', 'Kalender Akademik', 'Panduan & SOP', 'Dokumen Resmi', 'Materi Pembelajaran'];
        foreach ($kategoriDownload as $kd) {
            $existing = DB::table('common')->where('table_name', 'kategori_download')->where('data1', $kd)->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'kategori_download',
                'key1'       => $idGen->generateId('kategori_download'),
                'data1'      => $kd,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 25. Tag Konten (BARU)
        // =============================================
        $tagKonten = [
            'AI', 'Coding', 'Robotika', 'PKL', 'LKS', 'Seminar', 'Workshop',
            'Prestasi', 'PPDB', 'Alumni', 'Beasiswa', 'Wisuda',
        ];
        // =============================================
        // 26. Karya Siswa / Karya Kreatif
        // =============================================
        $karyaSiswaData = [
            [
                'title' => 'Aplikasi IoT Monitoring Pertanian Pintar',
                'description' => 'Sistem monitoring kelembapan tanah, suhu, dan penyiraman otomatis berbasis IoT yang terintegrasi dengan aplikasi mobile.',
                'jurusan_kode' => 'RPL',
                'photo' => null
            ],
            [
                'title' => 'Rancang Bangun Jaringan Server Cloud Lokal',
                'description' => 'Solusi infrastruktur cloud lokal menggunakan Kubernetes untuk menunjang virtualisasi laboratorium komputer sekolah.',
                'jurusan_kode' => 'TJKT',
                'photo' => null
            ],
            [
                'title' => 'Sistem Informasi Kasir & Inventory Toko Retail',
                'description' => 'Aplikasi POS (Point of Sales) berbasis web yang dilengkapi dengan modul laporan keuangan otomatis dan inventory tracking.',
                'jurusan_kode' => 'RPL',
                'photo' => null
            ],
            [
                'title' => 'Sistem Keamanan Pintar Menggunakan Pengenalan Wajah',
                'description' => 'Prototipe sistem keamanan pintu gerbang sekolah dengan face recognition menggunakan kamera pintar Raspberry Pi.',
                'jurusan_kode' => 'TJKT',
                'photo' => null
            ],
            [
                'title' => 'Audit Laporan Keuangan Digital UMKM',
                'description' => 'Penyusunan dan digitalisasi laporan keuangan menggunakan aplikasi pencatatan akuntansi modern untuk UMKM binaan sekolah.',
                'jurusan_kode' => 'AKL',
                'photo' => null
            ]
        ];

        foreach ($karyaSiswaData as $ks) {
            $existing = DB::table('common')->where('table_name', 'karya_siswa')->where('data1', $ks['title'])->first();
            if ($existing) continue;
            DB::table('common')->insert([
                'table_name' => 'karya_siswa',
                'key1'       => $idGen->generateId('karya_siswa'),
                'data1'      => $ks['title'],
                'data2'      => $ks['photo'],
                'data3'      => $jurusanIds[$ks['jurusan_kode']] ?? null,
                'text1'      => $ks['description'],
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
