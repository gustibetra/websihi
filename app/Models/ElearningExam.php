<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningExam extends Model
{
    protected $table = 'elearning_exams';

    protected $fillable = [
        'course_id', 'title', 'type', 'instructions', 'soal_path',
        'start_at', 'end_at', 'is_open',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'is_open'  => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(ElearningCourse::class, 'course_id');
    }

    public function submissions()
    {
        return $this->hasMany(ElearningExamSubmission::class, 'exam_id');
    }

    public function isUjian(): bool
    {
        return ($this->type ?? 'ujian') === 'ujian';
    }

    public function isTugas(): bool
    {
        return $this->type === 'tugas';
    }

    /** ✅ AMAN: tidak crash walau start_at/end_at NULL */
    public function isOpen(): bool
    {
        if ($this->is_open) {
            return true;
        }
        if (!$this->start_at || !$this->end_at) {
            return false;
        }
        return now()->between($this->start_at, $this->end_at);
    }

    public function isClosed(): bool
    {
        return !$this->isOpen();
    }
}