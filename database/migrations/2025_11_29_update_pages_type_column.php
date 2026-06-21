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
        // Update existing 'blog' values to 'page'
        DB::table('pages')
            ->where('page_type', 'blog')
            ->update(['page_type' => 'page']);

        // Change column type from enum to varchar
        Schema::table('pages', function (Blueprint $table) {
            $table->string('page_type', 50)->default('page')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'page' values back to 'blog'
        DB::table('pages')
            ->where('page_type', 'page')
            ->update(['page_type' => 'blog']);

        // Change column type back to enum
        Schema::table('pages', function (Blueprint $table) {
            $table->enum('page_type', ['blog', 'structure'])->default('blog')->change();
        });
    }
};
