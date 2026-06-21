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
        // Kolom-kolom ini sudah ada di migration create_pages_table (2025_11_05_101143).
        // Migration ini dibiarkan kosong untuk menghindari error duplikat kolom.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak ada yang perlu di-rollback karena up() tidak melakukan apa-apa.
    }
};
