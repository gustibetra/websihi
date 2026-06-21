<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'kode',
        'singkatan',
        'nama',
        'ka_prodi',
        'akreditasi',
        'logo',
        'banner',
        'video_url',
        'email',
        'phone',
        'tahun_berdiri',
        'deskripsi',
        'deskripsi_singkat',
        'visi',
        'misi',
        'tujuan',
        'profil_lulusan',
        'kurikulum',
        'order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function kepalaProdi(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'ka_prodi');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}
