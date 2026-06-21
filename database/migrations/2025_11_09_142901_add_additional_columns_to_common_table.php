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
            // Add data11 to data15 columns
            $table->string('data11', 255)->nullable()->after('data10');
            $table->string('data12', 255)->nullable()->after('data11');
            $table->string('data13', 255)->nullable()->after('data12');
            $table->string('data14', 255)->nullable()->after('data13');
            $table->string('data15', 255)->nullable()->after('data14');
            
            // Add date1 to date4 columns
            $table->date('date1')->nullable()->after('data15');
            $table->date('date2')->nullable()->after('date1');
            $table->date('date3')->nullable()->after('date2');
            $table->date('date4')->nullable()->after('date3');
            
            // Add text1 to text4 columns
            $table->text('text1')->nullable()->after('date4');
            $table->text('text2')->nullable()->after('text1');
            $table->text('text3')->nullable()->after('text2');
            $table->text('text4')->nullable()->after('text3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('common', function (Blueprint $table) {
            $table->dropColumn([
                'data11', 'data12', 'data13', 'data14', 'data15',
                'date1', 'date2', 'date3', 'date4',
                'text1', 'text2', 'text3', 'text4'
            ]);
        });
    }
};
