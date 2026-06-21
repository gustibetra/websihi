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
        Schema::table('common', function (Blueprint $table) {
            // Add unique constraint on (table_name, key1) where key1 is not null
            // Note: MySQL doesn't support partial unique index, so we'll use composite unique index
            // This ensures key1 is unique per table_name
            $table->unique(['table_name', 'key1'], 'common_table_name_key1_unique');
            
            // Add index for better query performance
            $table->index(['table_name', 'key1'], 'common_table_name_key1_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('common', function (Blueprint $table) {
            $table->dropUnique('common_table_name_key1_unique');
            $table->dropIndex('common_table_name_key1_index');
        });
    }
};
