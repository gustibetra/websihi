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
        Schema::table('achievements', function (Blueprint $table) {
            $table->string('type', 20)->default('siswa')->after('id');
            $table->text('photo')->nullable()->change();
            $table->text('student_ids')->nullable()->after('achiever');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->string('photo', 255)->nullable()->change();
            $table->dropColumn('student_ids');
        });
    }
};
