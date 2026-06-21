<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transparency extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'category_id',
        'title',
        'description',
        'file',
        'year',
        'period',
        'is_public',
        'is_active',
        'custom1',
        'custom2',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user who created this transparency record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated this transparency record.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the category for this transparency record.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'category_id');
    }
}
