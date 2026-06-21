<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'category_id',
        'jurusan_id',
        'upload_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'upload_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'category_id');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'jurusan_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(GalleryImage::class)->orderBy('sort_order')->orderBy('id');
    }
}