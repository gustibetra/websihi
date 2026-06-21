<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'phone',
        'photo',
        'role',
        'jurusan_id',
        'is_active',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'last_login' => 'datetime',
            'password'   => 'hashed',
        ];
    }

    // ─── Role Helpers ────────────────────────────────────────────────────────

    public function isSuperAdmin(): bool
    {
        return $this->role === 'SuperAdmin';
    }

    /**
     * Admin = Admin Jurusan (akses terbatas ke jurusan-nya)
     * SuperAdmin juga dianggap "admin" untuk keperluan general.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['SuperAdmin', 'Admin']);
    }

    public function isAdminJurusan(): bool
    {
        return $this->role === 'Admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'Operator';
    }

    public function isOperator(): bool
    {
        return $this->role === 'Operator';
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /**
     * Jurusan yang dikelola (hanya untuk role Admin/Jurusan).
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'jurusan_id');
    }

    /**
     * Galleries yang diupload oleh user ini.
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'upload_by');
    }
}
