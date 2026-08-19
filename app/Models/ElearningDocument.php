<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningDocument extends Model
{
    protected $table = 'elearning_documents';

    protected $fillable = [
        'student_id', 'title', 'category', 'drive_link', 'notes',
        'status', 'feedback', 'reviewed_by', 'submitted_at',
    ];

    protected $casts = ['submitted_at' => 'datetime'];

    public function student()
    {
        return $this->belongsTo(ElearningUser::class, 'student_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(ElearningUser::class, 'reviewed_by');
    }
}