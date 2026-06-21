<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\GifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    protected ?ImageManager $imageManager = null;

    public function __construct()
    {
        // Defer instantiation to prevent GD errors on page load when not uploading
    }

    protected function getImageManager(): ImageManager
    {
        if ($this->imageManager === null) {
            $this->imageManager = new ImageManager(new Driver());
        }
        return $this->imageManager;
    }

    /**
     * Upload file
     */
    public function upload(UploadedFile $file, string $folder = 'uploads', string $disk = 'public'): string
    {
        // Use original filename with timestamp to avoid conflicts
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug($originalName) . '_' . time() . '.' . $extension;
        $path = $file->storeAs($folder, $filename, $disk);
        
        return $path;
    }

    /**
     * Upload and resize image
     */
    public function uploadAndResize(
        UploadedFile $file,
        string $folder = 'uploads',
        int $width = 800,
        int $height = 600,
        string $disk = 'public'
    ): string {
        // Use original filename with timestamp to avoid conflicts
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug($originalName) . '_' . time() . '.' . $extension;
        
        // Read and resize image without upscaling to avoid quality degradation.
        $image = $this->getImageManager()->read($file->getRealPath());
        $image->scaleDown(width: $width, height: $height);
        
        // Save to storage
        $path = $folder . '/' . $filename;
        $fullPath = Storage::disk($disk)->path($path);
        
        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Encode with higher quality to keep slider image sharp on homepage.
        $this->saveWithBestQuality($image, $fullPath, strtolower($extension));
        
        return $path;
    }

    /**
     * Save image with format-specific quality settings.
     */
    private function saveWithBestQuality($image, string $fullPath, string $extension): void
    {
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image->encode(new JpegEncoder(90, true))->save($fullPath);
                break;
            case 'webp':
                $image->encode(new WebpEncoder(90))->save($fullPath);
                break;
            case 'png':
                $image->encode(new PngEncoder())->save($fullPath);
                break;
            case 'gif':
                $image->encode(new GifEncoder())->save($fullPath);
                break;
            default:
                $image->save($fullPath);
                break;
        }
    }

    /**
     * Upload image with thumbnail
     */
    public function uploadWithThumbnail(
        UploadedFile $file,
        string $folder = 'uploads',
        int $width = 800,
        int $height = 600,
        int $thumbWidth = 300,
        int $thumbHeight = 200,
        string $disk = 'public'
    ): array {
        // Upload and resize main image
        $mainPath = $this->uploadAndResize($file, $folder, $width, $height, $disk);
        
        // Create thumbnail
        $fullPath = Storage::disk($disk)->path($mainPath);
        $image = $this->getImageManager()->read($fullPath);
        $image->scale(width: $thumbWidth, height: $thumbHeight);
        
        $thumbnailPath = str_replace(
            basename($mainPath),
            'thumb_' . basename($mainPath),
            $mainPath
        );
        
        $thumbnailFullPath = Storage::disk($disk)->path($thumbnailPath);
        $image->save($thumbnailFullPath);
        
        return [
            'main' => $mainPath,
            'thumbnail' => $thumbnailPath,
        ];
    }

    /**
     * Delete file
     */
    public function delete(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        return false;
    }

    /**
     * Get file URL
     */
    public function getUrl(string $path, string $disk = 'public'): string
    {
        return Storage::disk($disk)->url($path);
    }
}

