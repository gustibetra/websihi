<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_name',
        'managed_by',
        'address',
        'email',
        'phone',
        'office_hours',
        'fax',
        'website',
        'google_map',
        'logo',
        'logo_square',
        'favicon',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'whatsapp',
        'ppdb_link',
        'vision',
        'mission',
        'description',
        'active_period',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user who created this setting.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated this setting.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
