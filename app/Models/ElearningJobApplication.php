<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElearningJobApplication extends Model
{
    protected $table = 'elearning_job_applications';

    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'position',
        'cv_path',        // file CV lama (opsional)
        'drive_link',     // ✅ BARU: link Google Drive
        'job_posting_id', // ✅ BARU: relasi ke lowongan
        'intro',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ═══════════════════════════════════════════════════════
    // RELASI
    // ═══════════════════════════════════════════════════════

    /**
     * Lowongan yang dilamar (nullable — bisa "Lamaran Umum / Talent Pool")
     */
    public function posting(): BelongsTo
    {
        return $this->belongsTo(ElearningJobPosting::class, 'job_posting_id');
    }

    // ═══════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════

    /**
     * Cek apakah lamaran ini menggunakan link Google Drive
     */
    public function hasDriveLink(): bool
    {
        return !empty($this->drive_link);
    }

    /**
     * Cek apakah lamaran ini punya file CV yang diupload ke storage
     */
    public function hasCvFile(): bool
    {
        return !empty($this->cv_path);
    }

    /**
     * Cek apakah lamaran punya berkas (Drive ATAU file upload)
     */
    public function hasAttachment(): bool
    {
        return $this->hasDriveLink() || $this->hasCvFile();
    }

    /**
     * Ambil URL berkas (prioritas: Drive link > file storage)
     */
    public function getAttachmentUrlAttribute(): ?string
    {
        if ($this->hasDriveLink()) {
            return $this->drive_link;
        }

        if ($this->hasCvFile()) {
            return asset('storage/' . $this->cv_path);
        }

        return null;
    }

    /**
     * Label status dengan warna (untuk badge di view)
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Baru'     => 'bg-warning-subtle text-warning',
            'Diproses' => 'bg-info-subtle text-info',
            'Diterima' => 'bg-success-subtle text-success',
            'Ditolak'  => 'bg-danger-subtle text-danger',
            default    => 'bg-secondary-subtle text-secondary',
        };
    }

    /**
     * Format nomor WhatsApp ke format yang bisa di-klik (wa.me)
     * Contoh: 081234567890 → 6281234567890
     */
    public function getWhatsappLinkAttribute(): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $this->whatsapp ?? '');

        // Ubah prefix 0 jadi 62
        if (str_starts_with($cleaned, '0')) {
            $cleaned = '62' . substr($cleaned, 1);
        }

        return 'https://wa.me/' . $cleaned;
    }

    /**
     * Cek apakah ini lamaran umum (Talent Pool) atau lamaran ke posisi spesifik
     */
    public function isGeneralApplication(): bool
    {
        return empty($this->job_posting_id);
    }

    // ═══════════════════════════════════════════════════════
    // SCOPES (untuk query)
    // ═══════════════════════════════════════════════════════

    /**
     * Filter hanya lamaran dengan status tertentu
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Filter hanya lamaran yang punya link Drive
     */
    public function scopeWithDriveLink($query)
    {
        return $query->whereNotNull('drive_link')->where('drive_link', '!=', '');
    }

    /**
     * Urutkan dari yang terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderByDesc('created_at');
    }
}