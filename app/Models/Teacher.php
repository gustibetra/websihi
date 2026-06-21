<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * Model untuk Guru & Tenaga Kependidikan SMK.
 *
 * Tabel `teachers` di-repurpose dari data anggota DPRD.
 *
 * Kolom utama:
 *   - name, nip, photo, gender, birth_place, birth_date
 *   - address, phone, email
 *   - jabatan, jenis (guru|tendik), bidang_studi
 *   - pendidikan, status_kepegawaian
 *   - jurusan_id → FK ke common.id (table_name='jurusan')
 *   - order, is_active, description
 */
class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'name',
        'nip',
        'photo',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'phone',
        'email',
        'jabatan',
        'jenis',
        'bidang_studi',
        'pendidikan',
        'status_kepegawaian',
        'jurusan_id',
        'order',
        'is_active',
        'description',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'is_active'  => 'boolean',
        ];
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    /** Hanya guru */
    public function scopeGuru(Builder $query): Builder
    {
        return $query->where('jenis', 'guru');
    }

    /** Hanya tenaga kependidikan */
    public function scopeTendik(Builder $query): Builder
    {
        return $query->where('jenis', 'tendik');
    }

    /** Hanya yang aktif */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** Filter per jurusan */
    public function scopeJurusan(Builder $query, int $jurusanId): Builder
    {
        return $query->where('jurusan_id', $jurusanId);
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /** Jurusan yang diampu (opsional) */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'jurusan_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getJenisLabelAttribute(): string
    {
        return $this->jenis === 'guru' ? 'Guru' : 'Tenaga Kependidikan';
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
