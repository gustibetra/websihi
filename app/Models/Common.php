<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * Model Common — tabel serbaguna untuk berbagai master data SMK.
 *
 * Digunakan oleh table_name berikut:
 *   - jurusan         : Program Keahlian (data1=nama, data2=kode, data3=kepala_program, data4=akreditasi, text1=deskripsi, data5=foto)
 *   - kategori_berita : Kategori berita (data1=nama, data2=slug, data3=warna_badge)
 *   - mitra_industri  : Mitra DU/DI (data1=nama, data2=website, data3=logo, data4=bidang, text1=deskripsi_kerjasama)
 *   - alumni          : Alumni (data1=nama, data2=angkatan, data3=tempat_kerja, data4=jabatan, text1=testimoni, data5=foto)
 *   - prestasi        : Prestasi (data1=judul, data2=tingkat, data3=tahun, data4=kategori, data5=nama_siswa, text1=deskripsi, data6=foto)
 *   - download        : Download center (data1=judul, data2=kategori, data3=file_path, data4=ukuran_file)
 *   - fasilitas       : Fasilitas (data1=nama, data2=lokasi, data3=foto, text1=deskripsi, data4=kapasitas)
 *   - ppdb            : Info PPDB (data1=judul, data2=tahun_ajaran, text1=konten, date1=tgl_mulai, date2=tgl_selesai)
 */
class Common extends Model
{
    use HasFactory;

    protected $table = 'common';

    protected $fillable = [
        'table_name',
        'key1', 'key2', 'key3',
        'data1', 'data2', 'data3', 'data4', 'data5',
        'data6', 'data7', 'data8', 'data9', 'data10',
        'data11', 'data12', 'data13', 'data14', 'data15',
        'date1', 'date2', 'date3', 'date4',
        'text1', 'text2', 'text3', 'text4',
        'is_active',
        'order',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'date1'     => 'date',
            'date2'     => 'date',
            'date3'     => 'date',
            'date4'     => 'date',
            'is_active' => 'boolean',
        ];
    }

    // ─── Scopes per table_name ────────────────────────────────────────────────

    public function scopeJurusan(Builder $query): Builder
    {
        return $query->where('table_name', 'jurusan')->orderBy('order')->orderBy('data1');
    }

    public function scopeKategoriBerida(Builder $query): Builder
    {
        return $query->where('table_name', 'kategori_berita')->orderBy('data1');
    }

    public function scopeMitraIndustri(Builder $query): Builder
    {
        return $query->where('table_name', 'mitra_industri')->orderBy('order')->orderBy('data1');
    }

    public function scopeAlumni(Builder $query): Builder
    {
        return $query->where('table_name', 'alumni')->orderByDesc('data2');
    }

    public function scopePrestasi(Builder $query): Builder
    {
        return $query->where('table_name', 'prestasi')->orderByDesc('data3');
    }

    public function scopeDownload(Builder $query): Builder
    {
        return $query->where('table_name', 'download')->orderBy('data2')->orderBy('data1');
    }

    public function scopeFasilitas(Builder $query): Builder
    {
        return $query->where('table_name', 'fasilitas')->orderBy('order')->orderBy('data1');
    }

    /** Scope generik: filter by table_name */
    public function scopeByTable(Builder $query, string $tableName): Builder
    {
        return $query->where('table_name', $tableName);
    }

    /** Scope: hanya yang aktif */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // ─── Static Helpers ───────────────────────────────────────────────────────

    /**
     * Ambil semua record aktif untuk table_name tertentu.
     * Contoh: Common::getByTable('jurusan')
     */
    public static function getByTable(string $tableName, bool $activeOnly = true): \Illuminate\Database\Eloquent\Collection
    {
        $query = static::byTable($tableName)->orderBy('order')->orderBy('id');
        if ($activeOnly) {
            $query->aktif();
        }
        return $query->get();
    }

    /**
     * Ambil semua table_name yang unik (untuk listing di admin).
     */
    public static function getTableNames(): array
    {
        return static::distinct()->pluck('table_name')->sort()->values()->toArray();
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Halaman yang menggunakan structure ini (jika table_name = 'jurusan').
     */
    public function pages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Page::class, 'structure_common_id');
    }

    /**
     * Get members of this structure.
     */
    public function structureMembers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StructureMember::class, 'common_id')->orderBy('order');
    }

    /**
     * Get sections of this structure.
     */
    public function sections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StructureSection::class, 'common_id')->orderBy('order');
    }

    /**
     * Get the period for this structure (stored in data2).
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Common::class, 'data2');
    }
}
