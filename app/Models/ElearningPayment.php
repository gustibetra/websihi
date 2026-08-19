<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElearningPayment extends Model
{
    protected $table = 'elearning_payments';

    protected $fillable = [
        'student_id',
        'title',
        'amount',
        'due_date',
        'status',                  // Lunas | Tunggakan
        'paid_at',
        'payment_proof_link',
        'proof_type',
        'proof_note',
        'proof_submitted_at',
        'details',                 // JSON rincian biaya
        'payment_channel',
        'slip_number',
        'program',
        'manual_name',             // ✅ BARU: nama input manual (alumni/eksternal)
        'manual_nim',              // ✅ BARU: NIM input manual
    ];

    protected $casts = [
        'amount'              => 'decimal:2',
        'due_date'            => 'date',
        'paid_at'             => 'datetime',
        'proof_submitted_at'  => 'datetime',
        'details'             => 'array',
    ];

    // ─── Relasi ───────────────────────────────────────────────
    public function student(): BelongsTo
    {
        return $this->belongsTo(ElearningUser::class, 'student_id');
    }

    // ─── Helper Status ────────────────────────────────────────
    public function isLunas(): bool
    {
        return $this->status === 'Lunas';
    }

    public function isTunggakan(): bool
    {
        return $this->status === 'Tunggakan';
    }

    /** Cek apakah pembayaran ini berasal dari alumni / pembayar eksternal (tanpa student_id) */
    public function isManualPayment(): bool
    {
        return empty($this->student_id);
    }

    // ─── Helper Slip Pembayaran ───────────────────────────────

    public function getItemsAttribute(): \Illuminate\Support\Collection
    {
        return collect($this->details ?? []);
    }

    public function hasSlip(): bool
    {
        return !empty($this->slip_number);
    }

    public static function generateSlipNumber(int $id): string
    {
        return 'SIHI/' . now()->format('Ymd') . '/' . str_pad($id, 4, '0', STR_PAD_LEFT);
    }

    public function getTerbilangAttribute(): string
    {
        return strtoupper(trim($this->terbilang((int) $this->amount))) . ' RUPIAH';
    }

    private function terbilang(int $n): string
    {
        $h = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($n < 12)   return $h[$n];
        if ($n < 20)   return $this->terbilang($n - 10) . ' belas';
        if ($n < 100)  return $this->terbilang(intdiv($n, 10)) . ' puluh ' . $this->terbilang($n % 10);
        if ($n < 200)  return 'seratus ' . $this->terbilang($n - 100);
        if ($n < 1000) return $this->terbilang(intdiv($n, 100)) . ' ratus ' . $this->terbilang($n % 100);
        if ($n < 2000) return 'seribu ' . $this->terbilang($n - 1000);
        if ($n < 1000000) return $this->terbilang(intdiv($n, 1000)) . ' ribu ' . $this->terbilang($n % 1000);
        if ($n < 1000000000) return $this->terbilang(intdiv($n, 1000000)) . ' juta ' . $this->terbilang($n % 1000000);
        return $this->terbilang(intdiv($n, 1000000000)) . ' miliar ' . $this->terbilang($n % 1000000000);
    }

    // ─── Scope ────────────────────────────────────────────────
    public function scopeLunas($query)
    {
        return $query->where('status', 'Lunas');
    }

    public function scopeTunggakan($query)
    {
        return $query->where('status', 'Tunggakan');
    }

    /** Scope: hanya pembayaran manual (alumni/eksternal) */
    public function scopeManual($query)
    {
        return $query->whereNull('student_id');
    }

    // ─── Accessor ─────────────────────────────────────────────

    /**
     * ✅ Nama tampil (prioritas: akun tertaut → manual → fallback)
     * Digunakan di slip, tabel pembayaran, dll.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->student->name ?? $this->manual_name ?? '(Tanpa nama)';
    }

    /**
     * ✅ NIM tampil (prioritas: akun tertaut → manual → fallback)
     */
    public function getDisplayNimAttribute(): string
    {
        return $this->student->nomor_induk ?? $this->manual_nim ?? '-';
    }

    /** Format: Rp 1.500.000 (tanpa desimal) */
    public function getRupiahAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->amount, 0, ',', '.');
    }

    /** Format: Rp 1.500.000,00 (dengan 2 desimal, untuk slip) */
    public function getRupiahDetailAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->amount, 2, ',', '.');
    }

    /** Format tanggal jatuh tempo (id-ID) */
    public function getJatuhTempoIndoAttribute(): string
    {
        return $this->due_date ? $this->due_date->translatedFormat('d F Y') : '-';
    }

    /** Program display (fallback ke program mahasiswa) */
    public function getProgramDisplayAttribute(): string
    {
        return $this->program
            ?? $this->student?->program
            ?? '-';
    }

    /**
     * ✅ Sumber pembayaran (untuk label di tabel)
     * - "Mahasiswa" → tertaut ke akun
     * - "Alumni / Manual" → pembayaran tanpa akun
     */
    public function getSourceLabelAttribute(): string
    {
        return $this->isManualPayment()
            ? '<span class="badge bg-warning-subtle text-warning"><i class="ri-user-star-line me-1"></i>Alumni / Manual</span>'
            : '<span class="badge bg-info-subtle text-info"><i class="ri-user-3-line me-1"></i>Mahasiswa</span>';
    }
}