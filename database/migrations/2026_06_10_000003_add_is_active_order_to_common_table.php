<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom is_active dan order ke common table
     * agar master data (jurusan, alumni, prestasi, dll) bisa
     * difilter aktif/nonaktif dan diurutkan.
     */
    public function up(): void
    {
        Schema::table('common', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('updated_by')
                  ->comment('Status aktif/nonaktif record');
            $table->unsignedSmallInteger('order')->default(0)->after('is_active')
                  ->comment('Urutan tampil');

            // Index untuk query yang sering dipakai
            $table->index(['table_name', 'is_active'], 'common_table_active_idx');
            $table->index(['table_name', 'order'], 'common_table_order_idx');
        });
    }

    public function down(): void
    {
        Schema::table('common', function (Blueprint $table) {
            $table->dropIndex('common_table_active_idx');
            $table->dropIndex('common_table_order_idx');
            $table->dropColumn(['is_active', 'order']);
        });
    }
};
