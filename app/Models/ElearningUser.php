<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ElearningUser extends Authenticatable
{
    protected $table = 'elearning_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'staff_type',
        'nomor_induk',
        'program',
        'is_active',
        'photo',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function attendances()
    {
        return $this->hasMany(ElearningAttendance::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\ElearningPayment::class, 'student_id');
    }

    public function courses()
    {
        return $this->hasMany(\App\Models\ElearningCourse::class, 'owner_id');
    }
}