<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningAttendance extends Model
{
    protected $table = 'elearning_attendances';

    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
        'status',   // Hadir | Terlambat
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // ─── Relasi ───────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(ElearningUser::class, 'user_id');
    }

    // ─── Helper ───────────────────────────────────────────────
    public function isLate(): bool
    {
        return $this->status === 'Terlambat';
    }

    public function isComplete(): bool
    {
        return $this->check_in !== null && $this->check_out !== null;
    }
}