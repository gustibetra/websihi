<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'location',
        'title',
        'slug',
        'link_type',
        'page_id',
        'structure_id',
        'custom_url',
        'icon',
        'css_class',
        'order',
        'is_active',
        'open_new_tab',
        'description',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'open_new_tab' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Get the parent menu.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get the child menus.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get all children recursively.
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Get the page if link_type is 'page'.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    /**
     * Get the structure (common) if link_type is 'structure'.
     */
    public function structure(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'structure_id');
    }

    /**
     * Get the user who created this menu.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated this menu.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope to get only parent menus (no parent_id).
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get menus by location.
     */
    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', $location);
    }

    /**
     * Scope to get only active menus.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the full URL for this menu item.
     */
    public function getUrlAttribute(): ?string
    {
        return match ($this->link_type) {
            'page' => $this->page ? route('page.show', $this->page->slug) : null,
            'structure' => $this->page ? route('struktur.show', $this->page->slug) : null,
            'route' => $this->custom_url ? (\Illuminate\Support\Facades\Route::has($this->custom_url) ? route($this->custom_url) : url($this->custom_url)) : null,
            'url' => $this->custom_url,
            'group' => 'javascript:void(0);',
            default => null,
        };
    }

    /**
     * Check if menu is a group (no link).
     */
    public function isGroup(): bool
    {
        return $this->link_type === 'group';
    }

    /**
     * Check if menu has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    /**
     * Check if this menu item or any of its active children matches the current request path.
     */
    public function isActive(): bool
    {
        $menuUrl = $this->url;
        if ($menuUrl && $menuUrl !== 'javascript:void(0);' && $menuUrl !== '#') {
            $path = trim(parse_url($menuUrl, PHP_URL_PATH) ?? '', '/');
            if (request()->is($path ?: '/')) {
                return true;
            }
        }

        foreach ($this->children as $child) {
            if ($child->isActive()) {
                return true;
            }
        }

        return false;
    }
}
