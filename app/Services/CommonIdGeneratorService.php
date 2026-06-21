<?php

namespace App\Services;

use App\Repositories\CommonRepository;

class CommonIdGeneratorService
{
    /**
     * Prefix mapping untuk setiap table_name
     */
    private const PREFIX_MAP = [
        'structure' => [
            'organisasi' => 'OR',
            'ekskul' => 'EK',
            'kepanitiaan' => 'KP',
            'sekolah' => 'SK',
            'badan' => 'BD',
            'panitia' => 'PT',
        ],
        // Akademik
        'period' => 'PD',
        'tingkat_kelas' => 'TK',
        'kelas' => 'KL',
        'jurusan' => 'JR',
        'kompetensi_keahlian' => 'KK',
        'kurikulum' => 'KU',
        // Organisasi
        'jabatan_organisasi' => 'JB',
        'divisi' => 'DV',
        // Hubungan Industri
        'mitra_industri' => 'MT',
        'jenis_kerjasama' => 'JK',
        'bidang_industri' => 'BI',
        // Profil Tambahan
        'fasilitas' => 'FS',
        'sertifikasi' => 'SR',
        'program_unggulan' => 'PU',
        'kategori_prestasi' => 'GP',
        'tingkatan_prestasi' => 'TP',
        // Alumni
        'status_alumni' => 'SA',
        'bidang_pekerjaan' => 'BP',
        // Media & Publikasi
        'kategori_berita' => 'KB',
        'kategori_event' => 'KE',
        'kategori_pengumuman' => 'PN',
        'kategori_download' => 'KD',
        'kategori_galeri' => 'KG',
        'tag_konten' => 'TG',
        // legacy
        'news_category' => 'NC',
        'event_category' => 'EC',
        'announcement_category' => 'AC',
        'political_party' => 'PP',
        'position' => 'PS',
    ];

    public function __construct(
        private CommonRepository $repository
    ) {}

    /**
     * Generate ID untuk common table
     * 
     * @param string $tableName Nama table (contoh: 'structure', 'period')
     * @param string|null $structureType Type struktur (contoh: 'fraksi', 'komisi') - hanya untuk table_name='structure'
     * @return string Generated ID (contoh: 'FR01', 'KM01', 'DP01')
     */
    public function generateId(string $tableName, ?string $structureType = null): string
    {
        // Get prefix
        $prefix = $this->getPrefix($tableName, $structureType);

        // Get last ID for this table_name and structure_type
        $lastId = $this->getLastId($tableName, $prefix, $structureType);

        // Generate new ID
        $newNumber = $lastId + 1;
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get prefix berdasarkan table_name dan structure_type
     */
    private function getPrefix(string $tableName, ?string $structureType = null): string
    {
        if ($tableName === 'structure' && $structureType) {
            return self::PREFIX_MAP['structure'][$structureType] ?? 'ST';
        }

        return self::PREFIX_MAP[$tableName] ?? 'CM';
    }

    /**
     * Get last ID number untuk table_name tertentu
     */
    private function getLastId(string $tableName, string $prefix, ?string $structureType = null): int
    {
        // Untuk structure, kita filter berdasarkan prefix saja
        // karena key1 akan berisi ID (FR01, KM01, dll)
        // structure_type akan disimpan di key2 atau field lain
        return $this->getLastIdByPrefix($tableName, $prefix);
    }

    /**
     * Simplified version: Get last ID by prefix only
     * Lebih sederhana dan reliable
     */
    public function getLastIdByPrefix(string $tableName, string $prefix): int
    {
        // Get all records dengan prefix yang sesuai
        $records = $this->repository->query()
            ->where('table_name', $tableName)
            ->where('key1', 'LIKE', $prefix . '%')
            ->whereNotNull('key1')
            ->get();

        if ($records->isEmpty()) {
            return 0;
        }

        $maxNumber = 0;
        foreach ($records as $record) {
            $key1 = $record->key1;
            // Extract number from key1 (contoh: 'FR01' -> 1, 'FR10' -> 10, 'FR123' -> 123)
            if (preg_match('/^' . preg_quote($prefix, '/') . '(\d+)$/', $key1, $matches)) {
                $number = (int) $matches[1];
                if ($number > $maxNumber) {
                    $maxNumber = $number;
                }
            }
        }

        return $maxNumber;
    }

    /**
     * Generate ID dengan structure type dari key1
     * Untuk structure, kita bisa ambil structure type dari key1 (contoh: key1='dapil')
     */
    public function generateIdForStructure(string $structureType): string
    {
        $prefix = $this->getPrefix('structure', $structureType);
        
        // Get structures dengan structure type tertentu
        // Structure type ada di key1, lalu kita cari key1 yang sesuai prefix
        $lastId = $this->getLastIdByPrefix('structure', $prefix);
        
        $newNumber = $lastId + 1;
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Validate generated ID is unique
     */
    public function isIdUnique(string $tableName, string $key1): bool
    {
        $exists = $this->repository->query()
            ->where('table_name', $tableName)
            ->where('key1', $key1)
            ->exists();

        return !$exists;
    }
}

