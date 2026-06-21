<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ubah role DPRD (Admin/Operator) → SMK (SuperAdmin/Admin/Editor)
     * Tambah jurusan_id untuk Admin Jurusan
     */
    public function up(): void
    {
        // 1. Ubah enum → string dulu agar bisa diisi nilai baru
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20) NOT NULL DEFAULT 'Editor'");

        // 2. Update nilai lama ke nilai baru
        DB::table('users')->where('role', 'Admin')->update(['role' => 'SuperAdmin']);
        DB::table('users')->where('role', 'Operator')->update(['role' => 'Editor']);

        // 3. Ubah kembali ke enum dengan nilai baru
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('SuperAdmin', 'Admin', 'Editor') NOT NULL DEFAULT 'Editor'");

        // 4. Tambah kolom jurusan_id (FK ke common table, untuk Admin Jurusan)
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('role')
                  ->comment('FK ke common.id (table_name=jurusan) — diisi jika role = Admin');
        });
    }

    /**
     * Rollback: kembalikan ke role DPRD
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('jurusan_id');
        });

        DB::table('users')->where('role', 'SuperAdmin')->update(['role' => 'Admin']);
        DB::table('users')->where('role', 'Editor')->update(['role' => 'Operator']);

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Operator') NOT NULL DEFAULT 'Operator'");
    }
};
