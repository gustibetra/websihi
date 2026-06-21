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
        // 1. Create structure_sections table
        Schema::create('structure_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('common_id')->comment('FK to common (structure)');
            $table->string('name', 100);
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();

            $table->foreign('common_id')->references('id')->on('common')->onDelete('cascade');
        });

        // 2. Update structure_members table
        Schema::table('structure_members', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id')->nullable()->after('common_id')->comment('FK to structure_sections');
            $table->string('member_type', 100)->default('App\\Models\\Teacher')->after('member_id')->comment('Polymorphic relation class name');

            $table->foreign('section_id')->references('id')->on('structure_sections')->onDelete('set null');
            
            // Drop old unique constraint that doesn't support polymorphic member types and sections
            try {
                $table->dropUnique('idx_structure_member_period');
            } catch (\Exception $e) {
                // If the constraint name is different, log or ignore
            }
            
            // Add a new index that works with polymorphic fields
            $table->index(['common_id', 'section_id', 'member_id', 'member_type', 'period'], 'idx_structure_member_poly_sec');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('structure_members', function (Blueprint $table) {
            try {
                $table->dropIndex('idx_structure_member_poly_sec');
            } catch (\Exception $e) {}
            
            $table->dropForeign(['section_id']);
            $table->dropColumn(['section_id', 'member_type']);
            
            // Restore original unique constraint
            $table->unique(['common_id', 'member_id', 'period'], 'idx_structure_member_period');
        });

        Schema::dropIfExists('structure_sections');
    }
};
