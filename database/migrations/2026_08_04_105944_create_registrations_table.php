<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin');
            $table->string('tgl_lahir');
            $table->string('asal_sekolah');
            $table->text('alamat_rumah');
            $table->string('tahun_lulus');
            $table->string('jurusan_sekolah')->nullable();
            $table->string('no_whatsapp');
            $table->string('no_ortu')->nullable();
            $table->string('email');
            $table->string('program');
            $table->string('status')->default('Baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};