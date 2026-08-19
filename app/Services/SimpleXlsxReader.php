<?php

namespace App\Services;

use ZipArchive;

class SimpleXlsxReader
{
    /** Baca sheet pertama file .xlsx → array of rows */
    public static function read(string $filePath): array
    {
        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            throw new \Exception('File tidak valid sebagai XLSX. Simpan ulang sebagai .xlsx atau gunakan .csv');
        }

        // 1) Muat shared strings (teks yang disimpan terpisah)
        $shared = [];
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedXml) {
            $sx = simplexml_load_string($sharedXml);
            if ($sx && isset($sx->si)) {
                foreach ($sx->si as $si) {
                    $text = '';
                    if (isset($si->t))      $text = (string) $si->t;
                    elseif (isset($si->r))  foreach ($si->r as $r) $text .= (string) $r->t;
                    $shared[] = $text;
                }
            }
        }

        // 2) Muat sheet1
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();
        if (!$sheetXml) throw new \Exception('Sheet tidak ditemukan di dalam file.');

        $sheet = simplexml_load_string($sheetXml);
        $rows  = [];

        if ($sheet && $sheet->sheetData && $sheet->sheetData->row) {
            foreach ($sheet->sheetData->row as $row) {
                $rowData = [];
                foreach ($row->c as $c) {
                    $col   = self::columnIndex((string) $c->attributes()->r);
                    $type  = (string) $c->attributes()->t;
                    $value = '';

                    if ($type === 's') {           // shared string
                        $value = $shared[(int) ($c->v ?? -1)] ?? '';
                    } elseif ($type === 'inlineStr') {
                        $value = (string) ($c->is->t ?? '');
                    } else {                       // angka / biasa
                        $value = (string) ($c->v ?? '');
                    }
                    $rowData[$col] = $value;
                }
                if (!empty($rowData)) {
                    ksort($rowData);
                    $rows[] = $rowData;
                }
            }
        }

        return $rows;
    }

    /** "B3" → index kolom 1 */
    private static function columnIndex(string $ref): int
    {
        $letters = preg_replace('/[0-9]/', '', $ref);
        $index = 0;
        foreach (str_split($letters) as $ch) {
            $index = $index * 26 + (ord(strtoupper($ch)) - 64);
        }
        return max(0, $index - 1);
    }
}