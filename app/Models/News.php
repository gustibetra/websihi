<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should use database timestamps.
     * Override the default behavior to use database time instead of application time.
     */
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'author',
        'created_by',
        'updated_by',
        'category_id',
        'jurusan_id',
        'period',
        'published_at',
        'status',
        'tags',
        'view_count',
        'share_count',
        'is_featured',
        'source',
        'meta_title',
        'meta_description',
        'is_have_file',
        'file',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'view_count' => 'integer',
            'share_count' => 'integer',
            'is_featured' => 'boolean',
            'is_have_file' => 'boolean',
        ];
    }

    /**
     * Get the user who created this news.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the category for this news.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'category_id');
    }

    /**
     * Get the program (jurusan) for this news.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'jurusan_id');
    }


}
