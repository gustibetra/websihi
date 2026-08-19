<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningMaterial extends Model
{
    protected $table = 'elearning_materials';

    protected $fillable = [
        'course_id',
        'title',
        'file_path',
        'description',
    ];

    // ─── Relasi ───────────────────────────────────────────────
    public function course()
    {
        return $this->belongsTo(ElearningCourse::class, 'course_id');
    }

    // ─── Helper: URL file materi (storage publik) ─────────────
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}