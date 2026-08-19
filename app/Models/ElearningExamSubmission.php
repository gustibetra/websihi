<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningExamSubmission extends Model
{
    protected $table = 'elearning_exam_submissions';

    protected $fillable = [
        'exam_id',
        'student_id',
        'answer',
        'file_path',
        'drive_link',    // ← BARU: link Google Drive jawaban mahasiswa
        'score',
        'feedback',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'score'        => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────────
    public function exam()
    {
        return $this->belongsTo(ElearningExam::class, 'exam_id');
    }

    public function student()
    {
        return $this->belongsTo(ElearningUser::class, 'student_id');
    }

    // ─── Helper ───────────────────────────────────────────────
    public function isGraded(): bool
    {
        return $this->score !== null;
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    // Helper baru untuk link Google Drive
    public function hasDriveLink(): bool
    {
        return !empty($this->drive_link);
    }
}