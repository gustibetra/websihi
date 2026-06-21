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
        // 1. Add columns to news table
        Schema::table('news', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('category_id');
            $table->foreign('jurusan_id')->references('id')->on('programs')->onDelete('set null');
        });

        // 2. Add columns to announcement table
        Schema::table('announcement', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('category_id');
            $table->foreign('jurusan_id')->references('id')->on('programs')->onDelete('set null');
        });

        // 3. Add columns to events table
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('slug');
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('category_id');
            $table->foreign('category_id')->references('id')->on('common')->onDelete('set null');
            $table->foreign('jurusan_id')->references('id')->on('programs')->onDelete('set null');
        });

        // 4. Add columns to pages table
        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('period');
            $table->foreign('jurusan_id')->references('id')->on('programs')->onDelete('set null');
        });

        // 5. Add columns to galleries table
        Schema::table('galleries', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('slug');
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('category_id');
            $table->foreign('category_id')->references('id')->on('common')->onDelete('set null');
            $table->foreign('jurusan_id')->references('id')->on('programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove from galleries
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropForeign(['category_id']);
            $table->dropColumn(['jurusan_id', 'category_id']);
        });

        // Remove from pages
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
        });

        // Remove from events
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropForeign(['category_id']);
            $table->dropColumn(['jurusan_id', 'category_id']);
        });

        // Remove from announcement
        Schema::table('announcement', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
        });

        // Remove from news
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
        });
    }
};
