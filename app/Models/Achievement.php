<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    use HasFactory;

    protected $table = 'achievements';

    protected $fillable = [
        'type',
        'title',
        'achiever',
        'student_ids',
        'jurusan_id',
        'kategori_id',
        'tingkat_id',
        'date',
        'organizer',
        'description',
        'news_id',
        'photo',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'jurusan_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'kategori_id');
    }

    public function tingkat(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'tingkat_id');
    }

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getPhotoUrlsAttribute(): array
    {
        if (empty($this->photo)) {
            return [];
        }
        return array_map(fn($p) => asset('storage/' . $p), array_filter(explode(';', $this->photo)));
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (empty($this->photo)) {
            return null;
        }
        $photos = array_filter(explode(';', $this->photo));
        return !empty($photos) ? asset('storage/' . reset($photos)) : null;
    }

    public function getStudentsAttribute()
    {
        if (empty($this->student_ids)) {
            return collect();
        }
        $ids = array_filter(explode(',', $this->student_ids));
        return Student::whereIn('id', $ids)->get();
    }
}
