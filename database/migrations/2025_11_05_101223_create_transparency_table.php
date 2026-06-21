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
        Schema::create('transparency', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['anggaran', 'kinerja']);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('file', 255);
            $table->integer('year')->nullable();
            $table->string('period', 50)->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_active')->default(true);
            $table->string('custom1', 255)->nullable();
            $table->string('custom2', 255)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparency');
    }
};
