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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('achiever', 255);
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->unsignedBigInteger('tingkat_id')->nullable();
            $table->date('date')->nullable();
            $table->string('organizer', 255)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('news_id')->nullable();
            $table->string('photo', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('common')->onDelete('set null');
            $table->foreign('tingkat_id')->references('id')->on('common')->onDelete('set null');
            $table->foreign('news_id')->references('id')->on('news')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
