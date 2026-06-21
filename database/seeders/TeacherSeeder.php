<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user (admin) as creator
        $user = User::first();

        if (!$user) {
            $this->command->warn('No user found. Please run UserSeeder first.');
            return;
        }

        $this->command->info('Seeding Guru & Tendik data...');

        $teachers = [
            [
                'name' => 'Budi Santoso, S.Pd., M.Kom.',
                'nip' => '198005152005011001',
                'jenis' => 'guru',
                'jabatan' => 'Kepala Kompetensi Keahlian RPL',
                'bidang_studi' => 'Pemrograman Web dan Perangkat Bergerak',
                'pendidikan' => 'S2 Ilmu Komputer',
                'status_kepegawaian' => 'PNS',
                'gender' => 'male',
                'birth_place' => 'Bandung',
                'birth_date' => '1980-05-15',
                'address' => 'Jl. Merdeka No. 123, Bandung',
                'phone' => '081234567890',
                'email' => 'budi.santoso@smk.sch.id',
                'is_active' => true,
                'description' => 'Guru Produktif RPL',
            ],
            [
                'name' => 'Siti Aminah, S.Kom.',
                'nip' => '198508202010012002',
                'jenis' => 'guru',
                'jabatan' => 'Guru Produktif',
                'bidang_studi' => 'Basis Data',
                'pendidikan' => 'S1 Teknik Informatika',
                'status_kepegawaian' => 'PPPK',
                'gender' => 'female',
                'birth_place' => 'Jakarta',
                'birth_date' => '1985-08-20',
                'address' => 'Jl. Gatot Subroto No. 45, Bandung',
                'phone' => '081234567891',
                'email' => 'siti.aminah@smk.sch.id',
                'is_active' => true,
                'description' => 'Wali Kelas X RPL 1',
            ],
            [
                'name' => 'Deni Ramdhani',
                'nip' => '',
                'jenis' => 'tendik',
                'jabatan' => 'Kepala Tata Usaha',
                'bidang_studi' => '',
                'pendidikan' => 'D3 Administrasi Bisnis',
                'status_kepegawaian' => 'Honorer',
                'gender' => 'male',
                'birth_place' => 'Cimahi',
                'birth_date' => '1978-03-10',
                'address' => 'Jl. Ahmad Yani No. 67, Cimahi',
                'phone' => '081234567892',
                'email' => 'deni.ramdhani@smk.sch.id',
                'is_active' => true,
                'description' => 'Staf Tata Usaha Bidang Kepegawaian',
            ],
        ];

        foreach ($teachers as $index => $teacherData) {
            Teacher::updateOrCreate(
                ['name' => $teacherData['name']],
                array_merge($teacherData, [
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ])
            );
        }

        $this->command->info('Guru/Tendik created: ' . count($teachers) . ' personil');
    }
}
