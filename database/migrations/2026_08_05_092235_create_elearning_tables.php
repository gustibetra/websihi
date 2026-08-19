<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');                 // staff | mahasiswa
            $table->string('staff_type')->nullable(); // pengajar | administrasi | keuangan
            $table->string('nomor_induk')->nullable();
            $table->string('program')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('elearning_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('program')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('owner_id')->constrained('elearning_users')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('elearning_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('elearning_courses')->onDelete('cascade');
            $table->string('title');
            $table->string('file_path');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('elearning_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('elearning_courses')->onDelete('cascade');
            $table->string('title');
            $table->text('instructions')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->boolean('is_open')->default(false);
            $table->timestamps();
        });

        Schema::create('elearning_exam_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('elearning_exams')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('elearning_users')->onDelete('cascade');
            $table->text('answer')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('score')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('elearning_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('elearning_users')->onDelete('cascade');
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('status')->default('Hadir');
            $table->timestamps();
            $table->unique(['user_id', 'date']);
        });

        Schema::create('elearning_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('elearning_users')->onDelete('cascade');
            $table->string('title');
            $table->decimal('amount', 12, 0);
            $table->date('due_date')->nullable();
            $table->string('status')->default('Tunggakan'); // Lunas | Tunggakan
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['elearning_payments','elearning_attendances','elearning_exam_submissions','elearning_exams','elearning_materials','elearning_courses','elearning_users'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};