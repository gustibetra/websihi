<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    /**
     * Delete file from storage if exists
     */
    public static function deleteIfExists(?string $path, string $disk = 'public'): bool
    {
        if (!$path) return false;
        
        $fullPath = $disk === 'public' ? 'public/' . $path : $path;
        if (Storage::exists($fullPath)) {
            return Storage::delete($fullPath);
        }
        
        return false;
    }

    /**
     * Delete multiple files from storage
     */
    public static function deleteMultiple(array $paths, string $disk = 'public'): int
    {
        $deleted = 0;
        foreach ($paths as $path) {
            if (self::deleteIfExists($path, $disk)) {
                $deleted++;
            }
        }
        return $deleted;
    }
}

