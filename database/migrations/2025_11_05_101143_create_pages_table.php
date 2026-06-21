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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150)->unique();
            $table->enum('page_type', ['blog', 'structure'])->default('blog');
            $table->unsignedBigInteger('structure_common_id')->nullable();
            $table->string('structure_type', 100)->nullable();
            $table->string('period', 50)->nullable();
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->longText('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('banner', 255)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->string('custom1', 255)->nullable();
            $table->string('custom2', 255)->nullable();
            $table->string('custom3', 255)->nullable();
            $table->text('custom4')->nullable();
            $table->text('custom5')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('structure_common_id')->references('id')->on('common')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
