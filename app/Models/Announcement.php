<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'announcement';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'banner',
        'category_id',
        'jurusan_id',
        'period',
        'attachment',
        'start_date',
        'end_date',
        'is_public',
        'is_active',
        'custom1',
        'custom2',
        'custom3',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user who created this announcement.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated this announcement.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the category for this announcement.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'category_id');
    }

    /**
     * Get the program (jurusan) for this announcement.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'jurusan_id');
    }
}
