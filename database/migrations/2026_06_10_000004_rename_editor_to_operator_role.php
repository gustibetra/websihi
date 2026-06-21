<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ubah role 'Editor' menjadi 'Operator' sesuai kesepakatan akhir.
     * Final roles: SuperAdmin, Admin, Operator
     */
    public function up(): void
    {
        // 1. Ubah ke VARCHAR dulu agar bisa update nilai
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20) NOT NULL DEFAULT 'Operator'");

        // 2. Rename Editor → Operator
        DB::table('users')->where('role', 'Editor')->update(['role' => 'Operator']);

        // 3. Kembali ke ENUM dengan nilai final
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('SuperAdmin', 'Admin', 'Operator') NOT NULL DEFAULT 'Operator'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20) NOT NULL DEFAULT 'Operator'");
        DB::table('users')->where('role', 'Operator')->update(['role' => 'Editor']);
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('SuperAdmin', 'Admin', 'Editor') NOT NULL DEFAULT 'Editor'");
    }
};
