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
        // Alter enum to add 'route'
        DB::statement("ALTER TABLE menus MODIFY COLUMN link_type ENUM('page', 'structure', 'route', 'url', 'group') DEFAULT 'url'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE menus MODIFY COLUMN link_type ENUM('page', 'structure', 'url', 'group') DEFAULT 'url'");
    }
};
