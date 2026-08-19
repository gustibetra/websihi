<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningCourse extends Model
{
    protected $table = 'elearning_courses';

    protected $fillable = [
        'title',
        'program',
        'description',
        'owner_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Relasi ───────────────────────────────────────────────
    public function owner()
    {
        return $this->belongsTo(ElearningUser::class, 'owner_id');
    }

    public function materials()
    {
        return $this->hasMany(ElearningMaterial::class, 'course_id')->orderByDesc('id');
    }

    public function exams()
    {
        return $this->hasMany(ElearningExam::class, 'course_id')->orderByDesc('id');
    }

    // ─── Scope ────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}