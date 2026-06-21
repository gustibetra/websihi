<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'page_type',
        'structure_common_id',
        'structure_type',
        'period',
        'jurusan_id',
        'title',
        'subtitle',
        'content',
        'excerpt',
        'image',
        'banner',
        'attachment',
        'custom1',
        'custom2',
        'custom3',
        'custom4',
        'custom5',
        'is_active',
        'is_public',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_public' => 'boolean',
        ];
    }

    /**
     * Get the structure (common) for this page if page_type is 'structure'.
     */
    public function structure(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'structure_common_id');
    }

    /**
     * Get the program (jurusan) for this page.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'jurusan_id');
    }

    /**
     * Get the user who created this page.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated this page.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
