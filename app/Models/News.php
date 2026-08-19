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

    // ═══════════════════════════════════════════════════════
    // ✅ MULTI-FOTO ACCESSORS (Menyimpan banyak foto di kolom `image` sebagai JSON)
    // ═══════════════════════════════════════════════════════

    /**
     * Accessor agar $news->image tetap mengembalikan foto PERTAMA.
     * Ini menjaga kompatibilitas dengan semua view/kode lama yang hanya butuh 1 sampul.
     */
    public function getImageAttribute($value)
    {
        $images = $this->parseImages($value);
        return $images[0] ?? null;
    }

    /**
     * Accessor $news->images untuk mengembalikan SEMUA path foto (array).
     */
    public function getImagesAttribute(): array
    {
        return $this->parseImages($this->attributes['image'] ?? null);
    }

    /**
     * Accessor $news->image_urls untuk mengembalikan semua foto dalam URL lengkap (asset).
     */
    public function getImageUrlsAttribute(): array
    {
        return collect($this->images)
            ->map(fn($p) => $p ? asset('storage/' . $p) : null)
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Helper: deteksi data lama (string path tunggal) vs data baru (JSON array).
     */
    private function parseImages($raw): array
    {
        if (!$raw) return [];
        if (is_array($raw)) return array_values($raw);
        
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) return array_values($decoded);
        
        return [$raw]; // data lama: satu path string biasa
    }

    // ═══════════════════════════════════════════════════════
    // RELASI
    // ═══════════════════════════════════════════════════════

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