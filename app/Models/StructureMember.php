<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StructureMember extends Model
{
    use HasFactory;

    protected $table = 'structure_members';

    protected $fillable = [
        'common_id',
        'section_id',
        'member_id',
        'member_type',
        'period',
        'position',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the structure (common data).
     */
    public function structure(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'common_id');
    }

    /**
     * Get the section this member belongs to.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(StructureSection::class, 'section_id');
    }

    /**
     * Get the polymorphic member.
     */
    public function member()
    {
        return $this->morphTo('member', 'member_type', 'member_id');
    }

    /**
     * Legacy helper to get the person model
     */
    public function getPerson()
    {
        if (!$this->relationLoaded('member')) {
            $this->load('member');
        }
        return $this->member;
    }
}
