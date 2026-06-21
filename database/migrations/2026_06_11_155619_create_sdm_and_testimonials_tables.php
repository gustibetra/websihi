<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Students (Siswa)
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('nis', 20)->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('photo', 255); // Wajib ada foto
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->unsignedSmallInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        // 2. Alumni
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('photo', 255); // Wajib ada foto
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('tahun_lulus', 4);
            $table->string('tempat_kerja', 150)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('status_alumni', 100)->nullable();
            $table->string('bidang_pekerjaan', 100)->nullable();
            $table->text('testimoni')->nullable();
            $table->boolean('is_inspiratif')->default(false);
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->unsignedSmallInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        // 3. Structural Members (Struktural Yayasan)
        Schema::create('structural_members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('photo', 255); // Wajib ada foto
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('jabatan', 100); // Ketua Yayasan, Pembina, dll.
            $table->unsignedSmallInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        // 4. Testimonials (Testimoni Umum)
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('role', 100); // Alumni 2021, Orang Tua Siswa, DUDI
            $table->string('photo', 255)->nullable();
            $table->text('content');
            $table->unsignedSmallInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('structural_members');
        Schema::dropIfExists('alumni');
        Schema::dropIfExists('students');
    }
};
