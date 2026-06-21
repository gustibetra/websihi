<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default SuperAdmin
        User::updateOrCreate(
            ['username' => 'Andhika'],
            [
                'password'   => Hash::make('Andika98'),
                'name'       => 'Andhika Aulia',
                'email'      => 'admin@smk.sch.id',
                'phone'      => '6281312901432',
                'photo'      => null,
                'role'       => 'SuperAdmin',
                'jurusan_id' => null,
                'is_active'  => true,
                'last_login' => null,
            ]
        );

        $this->command->info('✅ SuperAdmin berhasil dibuat!');
        $this->command->info('   Username : Andhika');
        $this->command->info('   Password : Andika98');
        $this->command->info('   Role     : SuperAdmin');
    }
}
