<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create the programs table
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('singkatan', 50);
            $table->string('nama', 150);
            $table->string('ka_prodi', 150)->nullable();
            $table->string('akreditasi', 10)->nullable();
            $table->string('logo', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('kurikulum', 100)->nullable();
            $table->unsignedSmallInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        // 2. Migrate existing data from common (where table_name = 'jurusan')
        $jurusans = DB::table('common')->where('table_name', 'jurusan')->get();
        foreach ($jurusans as $jur) {
            DB::table('programs')->insert([
                'id'         => $jur->id,
                'kode'       => $jur->data2 ?? $jur->key1 ?? ('PROG-' . $jur->id),
                'singkatan'  => $jur->data2 ?? $jur->key1 ?? ('PROG-' . $jur->id),
                'nama'       => $jur->data1 ?? 'Program Baru',
                'ka_prodi'   => $jur->data3,
                'akreditasi' => $jur->data4,
                'logo'       => null,
                'deskripsi'  => $jur->text1,
                'kurikulum'  => null,
                'order'      => 0,
                'is_active'  => (bool) $jur->is_active,
                'created_by' => $jur->created_by,
                'updated_by' => $jur->updated_by,
                'created_at' => $jur->created_at ?? now(),
                'updated_at' => $jur->updated_at ?? now(),
            ]);
        }

        // 3. Drop the old foreign key constraint in achievements and point it to programs
        Schema::table('achievements', function (Blueprint $table) {
            // Drop old foreign key pointing to common(id)
            $table->dropForeign(['jurusan_id']);
            
            // Add new foreign key pointing to programs(id)
            $table->foreign('jurusan_id')
                  ->references('id')
                  ->on('programs')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Revert foreign key constraint in achievements to point to common
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->foreign('jurusan_id')
                  ->references('id')
                  ->on('common')
                  ->onDelete('set null');
        });

        // 2. Drop the programs table
        Schema::dropIfExists('programs');
    }
};
