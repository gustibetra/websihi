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
        Schema::create('common', function (Blueprint $table) {
            $table->id();
            $table->string('table_name', 50);
            $table->string('key1', 100)->nullable();
            $table->string('key2', 100)->nullable();
            $table->string('key3', 100)->nullable();
            $table->string('data1', 255)->nullable();
            $table->string('data2', 255)->nullable();
            $table->string('data3', 255)->nullable();
            $table->string('data4', 255)->nullable();
            $table->string('data5', 255)->nullable();
            $table->string('data6', 255)->nullable();
            $table->string('data7', 255)->nullable();
            $table->string('data8', 255)->nullable();
            $table->string('data9', 255)->nullable();
            $table->string('data10', 255)->nullable();
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
        Schema::dropIfExists('common');
    }
};
