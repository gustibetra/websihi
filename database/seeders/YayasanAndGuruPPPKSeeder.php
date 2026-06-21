<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\Teacher;
use App\Models\StructuralMember;
use App\Models\StructureSection;
use App\Models\StructureMember;
use App\Models\User;
use App\Services\CommonIdGeneratorService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class YayasanAndGuruPPPKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * SAFE: Only adds new data, never deletes existing real data.
     */
    public function run(): void
    {
        $this->command->info('Seeding Yayasan & Guru PPPK Structures...');

        $idGen  = app(CommonIdGeneratorService::class);
        $user   = User::first();
        $userId = $user ? $user->id : 1;

        // ─── Setup dummy photo ────────────────────────────────────────────────
        Storage::disk('public')->makeDirectory('structural');
        Storage::disk('public')->makeDirectory('teachers');

        $sourceDummy  = public_path('assets/admin/images/users/user-dummy-img.jpg');
        $structPhoto  = 'structural/dummy.jpg';
        $teacherPhoto = 'teachers/dummy.jpg';

        if (File::exists($sourceDummy)) {
            if (!File::exists(storage_path('app/public/' . $structPhoto))) {
                File::copy($sourceDummy, storage_path('app/public/' . $structPhoto));
            }
            if (!File::exists(storage_path('app/public/' . $teacherPhoto))) {
                File::copy($sourceDummy, storage_path('app/public/' . $teacherPhoto));
            }
        }

        // ─── Get active period ─────────────────────────────────────────────────
        $activePeriod = DB::table('common')
            ->where('table_name', 'period')
            ->where('data4', '1')
            ->first();
        $periodString = $activePeriod ? ($activePeriod->data1 ?? '2025/2026') : '2025/2026';

        // =====================================================================
        // PART 1: YAYASAN
        // =====================================================================

        // 1a. Insert StructuralMember (Yayasan people) if not already present
        $yayasanPeople = [
            [
                'name'        => 'Drs. H. Ahmad Fauzi, M.Pd.',
                'photo'       => $structPhoto,
                'gender'      => 'male',
                'birth_place' => 'Bandung',
                'birth_date'  => '1958-06-15',
                'address'     => 'Jl. Raya Dago No. 55, Bandung',
                'phone'       => '08112233441',
                'email'       => 'ahmad.fauzi@yayasan.org',
                'jabatan'     => 'Ketua Yayasan',
                'order'       => 1,
                'is_active'   => true,
                'description' => 'Pendiri dan pemimpin utama Yayasan Pendidikan. Berpengalaman lebih dari 30 tahun di bidang pendidikan nasional.',
                'created_by'  => $userId,
                'updated_by'  => $userId,
            ],
            [
                'name'        => 'Hj. Dewi Rahayu, S.H.',
                'photo'       => $structPhoto,
                'gender'      => 'female',
                'birth_place' => 'Jakarta',
                'birth_date'  => '1965-11-22',
                'address'     => 'Jl. Diponegoro No. 88, Bandung',
                'phone'       => '08112233442',
                'email'       => 'dewi.rahayu@yayasan.org',
                'jabatan'     => 'Wakil Ketua Yayasan',
                'order'       => 2,
                'is_active'   => true,
                'description' => 'Mengelola aspek hukum dan kelembagaan yayasan, serta mengawasi kepatuhan regulasi pendidikan.',
                'created_by'  => $userId,
                'updated_by'  => $userId,
            ],
            [
                'name'        => 'Prof. Dr. H. Mulyana Yusuf, M.Pd.',
                'photo'       => $structPhoto,
                'gender'      => 'male',
                'birth_place' => 'Bandung',
                'birth_date'  => '1955-03-24',
                'address'     => 'Jl. Dago Asri No. 10, Bandung',
                'phone'       => '08112233443',
                'email'       => 'mulyana.yusuf@yayasan.org',
                'jabatan'     => 'Ketua Dewan Pembina',
                'order'       => 3,
                'is_active'   => true,
                'description' => 'Pembina utama yang memberikan arahan strategis pengembangan pendidikan dan kebijakan yayasan.',
                'created_by'  => $userId,
                'updated_by'  => $userId,
            ],
            [
                'name'        => 'Dra. Hj. Sri Wulandari, M.M.',
                'photo'       => $structPhoto,
                'gender'      => 'female',
                'birth_place' => 'Surabaya',
                'birth_date'  => '1963-08-17',
                'address'     => 'Jl. Pasteur No. 45, Bandung',
                'phone'       => '08112233444',
                'email'       => 'sri.wulandari@yayasan.org',
                'jabatan'     => 'Sekretaris Yayasan',
                'order'       => 4,
                'is_active'   => true,
                'description' => 'Mengatur administrasi umum yayasan dan memastikan kelancaran tata kelola organisasi sehari-hari.',
                'created_by'  => $userId,
                'updated_by'  => $userId,
            ],
            [
                'name'        => 'H. Dedi Kurniawan, M.M.',
                'photo'       => $structPhoto,
                'gender'      => 'male',
                'birth_place' => 'Sumedang',
                'birth_date'  => '1968-10-09',
                'address'     => 'Jl. Kiara Condong No. 112, Bandung',
                'phone'       => '08112233445',
                'email'       => 'dedi.kurniawan@yayasan.org',
                'jabatan'     => 'Bendahara Yayasan',
                'order'       => 5,
                'is_active'   => true,
                'description' => 'Mengelola keuangan dan investasi yayasan serta memastikan transparansi laporan keuangan lembaga.',
                'created_by'  => $userId,
                'updated_by'  => $userId,
            ],
            [
                'name'        => 'Ir. Bambang Hermawan, M.T.',
                'photo'       => $structPhoto,
                'gender'      => 'male',
                'birth_place' => 'Yogyakarta',
                'birth_date'  => '1961-04-30',
                'address'     => 'Jl. Setia Budi No. 78, Bandung',
                'phone'       => '08112233446',
                'email'       => 'bambang.h@yayasan.org',
                'jabatan'     => 'Ketua Dewan Pengawas',
                'order'       => 6,
                'is_active'   => true,
                'description' => 'Mengawasi pelaksanaan program dan anggaran yayasan, serta memberikan rekomendasi pengembangan.',
                'created_by'  => $userId,
                'updated_by'  => $userId,
            ],
            [
                'name'        => 'Hj. Lina Marlina, S.E.',
                'photo'       => $structPhoto,
                'gender'      => 'female',
                'birth_place' => 'Jakarta',
                'birth_date'  => '1972-07-12',
                'address'     => 'Jl. Surya Sumantri No. 34, Bandung',
                'phone'       => '08112233447',
                'email'       => 'lina.marlina@yayasan.org',
                'jabatan'     => 'Anggota Dewan Pengawas',
                'order'       => 7,
                'is_active'   => true,
                'description' => 'Bertanggung jawab mengawasi administrasi dan tata kelola keuangan yayasan secara berkala.',
                'created_by'  => $userId,
                'updated_by'  => $userId,
            ],
        ];

        $yayasanMemberMap = []; // name => StructuralMember instance
        foreach ($yayasanPeople as $data) {
            $existing = StructuralMember::where('name', $data['name'])->first();
            if (!$existing) {
                $existing = StructuralMember::create($data);
            }
            $yayasanMemberMap[$data['name']] = $existing;
        }

        // 1b. Insert Yayasan structure in common table if not exists
        $yayasanStruct = DB::table('common')
            ->where('table_name', 'structure')
            ->where('data1', 'Struktur Yayasan')
            ->where('key2', 'yayasan')
            ->first();

        if (!$yayasanStruct) {
            $yayasanId = DB::table('common')->insertGetId([
                'table_name' => 'structure',
                'key1'       => $idGen->generateId('structure', 'yayasan'),
                'key2'       => 'yayasan',
                'data1'      => 'Struktur Yayasan',
                'data5'      => 'yayasan',
                'text1'      => 'Yayasan Pendidikan yang menaungi dan menyelenggarakan kegiatan pendidikan di sekolah ini.',
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $yayasanStruct = DB::table('common')->find($yayasanId);
        }

        // 1c. Only create sections if none exist yet (safe re-run)
        $existingSections = DB::table('structure_sections')
            ->where('common_id', $yayasanStruct->id)
            ->count();

        if ($existingSections === 0) {
            $secPembina = StructureSection::create([
                'common_id' => $yayasanStruct->id,
                'name'      => 'Dewan Pembina',
                'order'     => 1,
            ]);

            $secPengawas = StructureSection::create([
                'common_id' => $yayasanStruct->id,
                'name'      => 'Dewan Pengawas',
                'order'     => 2,
            ]);

            $secPengurus = StructureSection::create([
                'common_id' => $yayasanStruct->id,
                'name'      => 'Pengurus Harian',
                'order'     => 3,
            ]);

            // Assign members to Yayasan sections
            $yayasanAssignments = [
                // Dewan Pembina
                ['section' => $secPembina,  'name' => 'Prof. Dr. H. Mulyana Yusuf, M.Pd.', 'position' => 'Ketua Dewan Pembina',    'order' => 1],
                // Dewan Pengawas
                ['section' => $secPengawas, 'name' => 'Ir. Bambang Hermawan, M.T.',         'position' => 'Ketua Dewan Pengawas',   'order' => 1],
                ['section' => $secPengawas, 'name' => 'Hj. Lina Marlina, S.E.',             'position' => 'Anggota Dewan Pengawas', 'order' => 2],
                // Pengurus Harian
                ['section' => $secPengurus, 'name' => 'Drs. H. Ahmad Fauzi, M.Pd.',         'position' => 'Ketua Yayasan',          'order' => 1],
                ['section' => $secPengurus, 'name' => 'Hj. Dewi Rahayu, S.H.',              'position' => 'Wakil Ketua Yayasan',    'order' => 2],
                ['section' => $secPengurus, 'name' => 'Dra. Hj. Sri Wulandari, M.M.',       'position' => 'Sekretaris Yayasan',     'order' => 3],
                ['section' => $secPengurus, 'name' => 'H. Dedi Kurniawan, M.M.',            'position' => 'Bendahara Yayasan',      'order' => 4],
            ];

            foreach ($yayasanAssignments as $a) {
                $person = $yayasanMemberMap[$a['name']] ?? null;
                if ($person) {
                    StructureMember::create([
                        'common_id'   => $yayasanStruct->id,
                        'section_id'  => $a['section']->id,
                        'member_id'   => $person->id,
                        'member_type' => StructuralMember::class,
                        'period'      => $periodString,
                        'position'    => $a['position'],
                        'order'       => $a['order'],
                        'is_active'   => true,
                    ]);
                }
            }

            $this->command->info('✅ Yayasan structure & members seeded!');
        } else {
            $this->command->warn('⚠️  Yayasan sections already exist — skipping to avoid duplicate data.');
        }

        // =====================================================================
        // PART 2: GURU PPPK
        // =====================================================================

        // 2a. Add PPPK teachers if not already present
        $pppkTeachers = [
            [
                'name'               => 'Rini Susanti, S.Pd.',
                'nip'                => '198706122019032001',
                'jenis'              => 'guru',
                'jabatan'            => 'Guru Mapel Matematika',
                'bidang_studi'       => 'Matematika',
                'pendidikan'         => 'S1 Pendidikan Matematika',
                'status_kepegawaian' => 'PPPK',
                'gender'             => 'female',
                'birth_place'        => 'Bandung',
                'birth_date'         => '1987-06-12',
                'address'            => 'Jl. Kopo Permai No. 34, Bandung',
                'phone'              => '081334567890',
                'email'              => 'rini.susanti@smk.sch.id',
                'photo'              => $teacherPhoto,
                'is_active'          => true,
                'description'        => 'Guru PPPK bidang Matematika',
                'created_by'         => $userId,
                'updated_by'         => $userId,
            ],
            [
                'name'               => 'Eko Prasetyo, S.Kom.',
                'nip'                => '199003182019031002',
                'jenis'              => 'guru',
                'jabatan'            => 'Guru Produktif RPL',
                'bidang_studi'       => 'Rekayasa Perangkat Lunak',
                'pendidikan'         => 'S1 Teknik Informatika',
                'status_kepegawaian' => 'PPPK',
                'gender'             => 'male',
                'birth_place'        => 'Surabaya',
                'birth_date'         => '1990-03-18',
                'address'            => 'Jl. Antapani No. 56, Bandung',
                'phone'              => '081334567891',
                'email'              => 'eko.prasetyo@smk.sch.id',
                'photo'              => $teacherPhoto,
                'is_active'          => true,
                'description'        => 'Guru PPPK Produktif RPL',
                'created_by'         => $userId,
                'updated_by'         => $userId,
            ],
            [
                'name'               => 'Nur Hidayah, S.Pd.',
                'nip'                => '199201052020012001',
                'jenis'              => 'guru',
                'jabatan'            => 'Guru Bahasa Indonesia',
                'bidang_studi'       => 'Bahasa Indonesia',
                'pendidikan'         => 'S1 Pendidikan Bahasa Indonesia',
                'status_kepegawaian' => 'PPPK',
                'gender'             => 'female',
                'birth_place'        => 'Bogor',
                'birth_date'         => '1992-01-05',
                'address'            => 'Jl. Pasteur Permai Blok A2, Bandung',
                'phone'              => '081334567892',
                'email'              => 'nur.hidayah@smk.sch.id',
                'photo'              => $teacherPhoto,
                'is_active'          => true,
                'description'        => 'Guru PPPK bidang Bahasa Indonesia',
                'created_by'         => $userId,
                'updated_by'         => $userId,
            ],
        ];

        $pppkMap = [];
        foreach ($pppkTeachers as $data) {
            $existing = Teacher::where('name', $data['name'])->first();
            if (!$existing) {
                $existing = Teacher::create($data);
            }
            $pppkMap[$data['name']] = $existing;
        }

        // Also include existing PPPK teacher from TeacherSeeder
        $sitiAminah = Teacher::where('name', 'Siti Aminah, S.Kom.')->first();
        if ($sitiAminah) {
            $pppkMap['Siti Aminah, S.Kom.'] = $sitiAminah;
        }

        // 2b. Insert Guru PPPK structure in common table if not exists
        $pppkStruct = DB::table('common')
            ->where('table_name', 'structure')
            ->where('data1', 'Guru PPPK')
            ->where('key2', 'sekolah')
            ->first();

        if (!$pppkStruct) {
            $pppkId = DB::table('common')->insertGetId([
                'table_name' => 'structure',
                'key1'       => $idGen->generateId('structure', 'sekolah'),
                'key2'       => 'sekolah',
                'data1'      => 'Guru PPPK',
                'data5'      => 'sekolah',
                'text1'      => 'Daftar Guru Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) yang bertugas di sekolah ini.',
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $pppkStruct = DB::table('common')->find($pppkId);
        }

        // 2c. Only create sections if none exist yet
        $existingPppkSections = DB::table('structure_sections')
            ->where('common_id', $pppkStruct->id)
            ->count();

        if ($existingPppkSections === 0) {
            $secGurumapel    = StructureSection::create([
                'common_id' => $pppkStruct->id,
                'name'      => 'Guru Mata Pelajaran Umum',
                'order'     => 1,
            ]);

            $secGuruproduktif = StructureSection::create([
                'common_id' => $pppkStruct->id,
                'name'      => 'Guru Produktif',
                'order'     => 2,
            ]);

            // Assign PPPK teachers
            $pppkAssignments = [
                ['section' => $secGurumapel,    'name' => 'Rini Susanti, S.Pd.',     'position' => 'Guru Matematika (PPPK)',            'order' => 1],
                ['section' => $secGurumapel,    'name' => 'Nur Hidayah, S.Pd.',      'position' => 'Guru Bahasa Indonesia (PPPK)',      'order' => 2],
                ['section' => $secGuruproduktif,'name' => 'Siti Aminah, S.Kom.',     'position' => 'Guru Produktif Basis Data (PPPK)', 'order' => 1],
                ['section' => $secGuruproduktif,'name' => 'Eko Prasetyo, S.Kom.',    'position' => 'Guru Produktif RPL (PPPK)',         'order' => 2],
            ];

            foreach ($pppkAssignments as $a) {
                $teacher = $pppkMap[$a['name']] ?? null;
                if ($teacher) {
                    StructureMember::create([
                        'common_id'   => $pppkStruct->id,
                        'section_id'  => $a['section']->id,
                        'member_id'   => $teacher->id,
                        'member_type' => Teacher::class,
                        'period'      => $periodString,
                        'position'    => $a['position'],
                        'order'       => $a['order'],
                        'is_active'   => true,
                    ]);
                }
            }

            $this->command->info('✅ Guru PPPK structure & members seeded!');
        } else {
            $this->command->warn('⚠️  Guru PPPK sections already exist — skipping to avoid duplicate data.');
        }

        $this->command->info('');
        $this->command->info('📌 Selanjutnya: Buat Page entry di admin panel untuk struktur ini:');
        $this->command->info('   → Yayasan  : page_type=structure, structure_common_id = id of "Struktur Yayasan"');
        $this->command->info('   → Guru PPPK: page_type=structure, structure_common_id = id of "Guru PPPK"');
    }
}
