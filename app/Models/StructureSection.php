<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StructureSection extends Model
{
    use HasFactory;

    protected $table = 'structure_sections';

    protected $fillable = [
        'common_id',
        'name',
        'order'
    ];

    /**
     * Get the structure (common data) this section belongs to.
     */
    public function structure(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'common_id');
    }

    /**
     * Get the members assigned to this section.
     */
    public function members(): HasMany
    {
        return $this->hasMany(StructureMember::class, 'section_id')->orderBy('order');
    }
}
