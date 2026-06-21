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
        Schema::table('programs', function (Blueprint $table) {
            $table->string('deskripsi_singkat', 500)->nullable()->after('deskripsi');
            $table->text('visi')->nullable()->after('deskripsi_singkat');
            $table->text('misi')->nullable()->after('visi');
            $table->text('tujuan')->nullable()->after('misi');
            $table->text('profil_lulusan')->nullable()->after('tujuan');
            $table->string('banner', 255)->nullable()->after('logo');
            $table->string('video_url', 500)->nullable()->after('banner');
            $table->string('email', 100)->nullable()->after('video_url');
            $table->string('phone', 30)->nullable()->after('email');
            $table->unsignedInteger('tahun_berdiri')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn([
                'deskripsi_singkat',
                'visi',
                'misi',
                'tujuan',
                'profil_lulusan',
                'banner',
                'video_url',
                'email',
                'phone',
                'tahun_berdiri',
            ]);
        });
    }
};
