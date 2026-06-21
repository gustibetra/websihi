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
        Schema::create('structure_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('common_id')->comment('Reference ke common (structure: Dapil 1, Komisi A, dll)');
            $table->unsignedBigInteger('member_id')->comment('Reference ke members');
            $table->string('period', 50)->nullable()->comment('Period (contoh: "2019-2024") - reference ke common atau string');
            $table->string('position', 100)->nullable()->comment('Posisi di struktur (contoh: "Ketua", "Anggota", "Wakil Ketua")');
            $table->integer('order')->default(0)->comment('Urutan tampil');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->unique(['common_id', 'member_id', 'period'], 'idx_structure_member_period');
            $table->index('common_id');
            $table->index('member_id');
            $table->index('period');
            $table->index('is_active');

            // Foreign keys
            $table->foreign('common_id')->references('id')->on('common')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structure_members');
    }
};
