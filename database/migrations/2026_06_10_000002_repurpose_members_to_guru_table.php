<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Repurpose tabel members dari data Anggota Dewan DPRD
     * menjadi data Guru & Tenaga Kependidikan SMK.
     *
     * Kolom yang dipertahankan (masih relevan):
     *   - name, photo, gender, birth_place, birth_date
     *   - address, phone, email, is_active, description
     *   - created_by, updated_by, timestamps
     *
     * Kolom yang dihapus (DPRD-specific):
     *   - party, fraction_id, dapil_id, position (→ diganti jabatan), commission, period
     *
     * Kolom baru yang ditambahkan (SMK-specific):
     *   - nip          : Nomor Induk Pegawai
     *   - jenis        : 'guru' | 'tendik' (Tenaga Kependidikan)
     *   - jabatan      : Jabatan (Guru Mapel, Wali Kelas, Kepala Program, dll)
     *   - bidang_studi : Mata pelajaran / bidang keahlian
     *   - pendidikan   : Pendidikan terakhir (S1, S2, dll)
     *   - status       : 'PNS' | 'PPPK' | 'Honorer' | 'GTT'
     *   - jurusan_id   : FK ke common.id (table_name='jurusan'), nullable
     *   - order        : Urutan tampil
     */
    public function up(): void
    {
        // 1. Ubah nama tabel dari members ke teachers
        Schema::rename('members', 'teachers');

        // 2. Modifikasi struktur tabel teachers
        Schema::table('teachers', function (Blueprint $table) {
            // Hapus kolom DPRD-specific
            $table->dropColumn(['party', 'fraction_id', 'dapil_id', 'commission', 'period']);

            // Ubah 'position' → 'jabatan' (repurpose, tidak drop dulu karena sudah ada)
            $table->renameColumn('position', 'jabatan');

            // Tambah kolom SMK-specific
            $table->string('nip', 30)->nullable()->after('name')->comment('Nomor Induk Pegawai');
            $table->enum('jenis', ['guru', 'tendik'])->default('guru')->after('jabatan')
                  ->comment('guru = Guru, tendik = Tenaga Kependidikan');
            $table->string('bidang_studi', 150)->nullable()->after('jenis')
                  ->comment('Mata pelajaran atau bidang keahlian');
            $table->string('pendidikan', 100)->nullable()->after('bidang_studi')
                  ->comment('Pendidikan terakhir: S1, S2, dll');
            $table->enum('status_kepegawaian', ['PNS', 'PPPK', 'Honorer', 'GTT'])->nullable()->after('pendidikan');
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('status_kepegawaian')
                  ->comment('FK ke common.id (table_name=jurusan), untuk guru yang terikat jurusan');
            $table->unsignedSmallInteger('order')->default(0)->after('jurusan_id')
                  ->comment('Urutan tampil');
        });
    }

    /**
     * Rollback: kembalikan ke struktur DPRD
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Hapus kolom SMK
            $table->dropColumn(['nip', 'jenis', 'bidang_studi', 'pendidikan', 'status_kepegawaian', 'jurusan_id', 'order']);

            // Kembalikan jabatan → position
            $table->renameColumn('jabatan', 'position');

            // Tambah kembali kolom DPRD
            $table->string('party', 100)->nullable();
            $table->unsignedBigInteger('fraction_id')->nullable();
            $table->unsignedBigInteger('dapil_id')->nullable();
            $table->string('commission', 100)->nullable();
            $table->string('period', 50)->nullable();
        });

        // Kembalikan nama tabel ke members
        Schema::rename('teachers', 'members');
    }
};
