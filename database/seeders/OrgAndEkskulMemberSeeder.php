<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\StructureSection;
use App\Models\StructureMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrgAndEkskulMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Org & Ekskul Sections and Members...');

        // Get active period
        $activePeriod = DB::table('common')
            ->where('table_name', 'period')
            ->where('data4', '1') // active period flag
            ->first();
        $periodString = $activePeriod ? $activePeriod->key1 : '2024/2025';

        // Truncate sections and members for OSIS, MPK, Pramuka, PMR, Paskibra, IT Club to be fresh
        $structures = DB::table('common')
            ->where('table_name', 'structure')
            ->whereIn('key2', ['organisasi', 'ekskul'])
            ->get();

        $structureIds = $structures->pluck('id')->toArray();

        // Clear existing sections & members for these structures
        DB::table('structure_members')->whereIn('common_id', $structureIds)->delete();
        DB::table('structure_sections')->whereIn('common_id', $structureIds)->delete();

        // Get some teachers and students to assign
        $teachers = Teacher::orderBy('id')->get();
        $students = Student::orderBy('id')->get();

        if ($teachers->isEmpty() || $students->isEmpty()) {
            $this->command->warn('Teachers or Students tables are empty! Please run TeacherSeeder and SdmAndTestimonialsSeeder first.');
            return;
        }

        // Helper variables
        $t1 = $teachers->shift(); // Teacher 1
        $t2 = $teachers->shift() ?? $t1; // Teacher 2
        $t3 = $teachers->shift() ?? $t1; // Teacher 3

        $s1 = $students->shift(); // Student 1
        $s2 = $students->shift() ?? $s1; // Student 2
        $s3 = $students->shift() ?? $s1; // Student 3

        // 1. SEED OSIS 2024/2025
        $osis = $structures->firstWhere('data1', 'OSIS 2024/2025');
        if ($osis) {
            // Create Sections
            $secPembina = StructureSection::create([
                'common_id' => $osis->id,
                'name' => 'Majelis Pembimbing (Pembina)',
                'order' => 1,
            ]);

            $secHarian = StructureSection::create([
                'common_id' => $osis->id,
                'name' => 'Pengurus Harian OSIS',
                'order' => 2,
            ]);

            $secDivisi1 = StructureSection::create([
                'common_id' => $osis->id,
                'name' => 'Seksi Bidang Keimanan & Ketaqwaan',
                'order' => 3,
            ]);

            $secDivisi2 = StructureSection::create([
                'common_id' => $osis->id,
                'name' => 'Seksi Bidang Teknologi & Informasi',
                'order' => 4,
            ]);

            // Assign Members
            // Pembina (Teacher)
            StructureMember::create([
                'common_id' => $osis->id,
                'section_id' => $secPembina->id,
                'member_id' => $t1->id,
                'member_type' => Teacher::class,
                'period' => $periodString,
                'position' => 'Pembina OSIS Utama',
                'order' => 1,
                'is_active' => true,
            ]);

            // Pengurus Harian
            StructureMember::create([
                'common_id' => $osis->id,
                'section_id' => $secHarian->id,
                'member_id' => $s1->id,
                'member_type' => Student::class,
                'period' => $periodString,
                'position' => 'Ketua OSIS',
                'order' => 1,
                'is_active' => true,
            ]);

            StructureMember::create([
                'common_id' => $osis->id,
                'section_id' => $secHarian->id,
                'member_id' => $s2->id,
                'member_type' => Student::class,
                'period' => $periodString,
                'position' => 'Wakil Ketua OSIS',
                'order' => 2,
                'is_active' => true,
            ]);

            StructureMember::create([
                'common_id' => $osis->id,
                'section_id' => $secHarian->id,
                'member_id' => $s3->id,
                'member_type' => Student::class,
                'period' => $periodString,
                'position' => 'Bendahara Umum',
                'order' => 3,
                'is_active' => true,
            ]);

            // Divisi Keagamaan (Student 2 as Ketua Bidang)
            StructureMember::create([
                'common_id' => $osis->id,
                'section_id' => $secDivisi1->id,
                'member_id' => $s2->id,
                'member_type' => Student::class,
                'period' => $periodString,
                'position' => 'Ketua Sekbid Keagamaan',
                'order' => 1,
                'is_active' => true,
            ]);

            // Divisi IT (Student 3 as Ketua Bidang)
            StructureMember::create([
                'common_id' => $osis->id,
                'section_id' => $secDivisi2->id,
                'member_id' => $s3->id,
                'member_type' => Student::class,
                'period' => $periodString,
                'position' => 'Ketua Sekbid IT & Publikasi',
                'order' => 1,
                'is_active' => true,
            ]);
        }

        // 2. SEED PRAMUKA
        $pramuka = $structures->firstWhere('data1', 'Pramuka');
        if ($pramuka) {
            // Create Sections
            $secMabi = StructureSection::create([
                'common_id' => $pramuka->id,
                'name' => 'Majelis Pembimbing Gugus Depan (Kamabigus)',
                'order' => 1,
            ]);

            $secDewan = StructureSection::create([
                'common_id' => $pramuka->id,
                'name' => 'Dewan Ambalan (Penegak)',
                'order' => 2,
            ]);

            // Assign Members
            // Kamabigus (Teacher 2)
            StructureMember::create([
                'common_id' => $pramuka->id,
                'section_id' => $secMabi->id,
                'member_id' => $t2->id,
                'member_type' => Teacher::class,
                'period' => $periodString,
                'position' => 'Pembina Pramuka / Kamabigus',
                'order' => 1,
                'is_active' => true,
            ]);

            // Dewan Ambalan
            StructureMember::create([
                'common_id' => $pramuka->id,
                'section_id' => $secDewan->id,
                'member_id' => $s3->id,
                'member_type' => Student::class,
                'period' => $periodString,
                'position' => 'Pradana (Ketua Dewan Ambalan)',
                'order' => 1,
                'is_active' => true,
            ]);

            StructureMember::create([
                'common_id' => $pramuka->id,
                'section_id' => $secDewan->id,
                'member_id' => $s1->id,
                'member_type' => Student::class,
                'period' => $periodString,
                'position' => 'Kerani (Sekretaris)',
                'order' => 2,
                'is_active' => true,
            ]);
        }

        // 3. SEED PMR
        $pmr = $structures->firstWhere('data1', 'PMR');
        if ($pmr) {
            // Create Sections
            $secPembinaPmr = StructureSection::create([
                'common_id' => $pmr->id,
                'name' => 'Pembina PMR',
                'order' => 1,
            ]);

            $secHarianPmr = StructureSection::create([
                'common_id' => $pmr->id,
                'name' => 'Pengurus Harian PMR',
                'order' => 2,
            ]);

            // Assign Members
            // Pembina PMR (Teacher 3)
            StructureMember::create([
                'common_id' => $pmr->id,
                'section_id' => $secPembinaPmr->id,
                'member_id' => $t3->id,
                'member_type' => Teacher::class,
                'period' => $periodString,
                'position' => 'Pembina Unit PMR Wira',
                'order' => 1,
                'is_active' => true,
            ]);

            // Pengurus Harian
            StructureMember::create([
                'common_id' => $pmr->id,
                'section_id' => $secHarianPmr->id,
                'member_id' => $s2->id,
                'member_type' => Student::class,
                'period' => $periodString,
                'position' => 'Komandan Unit PMR',
                'order' => 1,
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ Org & Ekskul Sections and Members seeded successfully!');
    }
}
