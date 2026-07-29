<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadImageTrait
{

    /**
     * Upload single image
     */
    public function uploadImage(UploadedFile $file, string $folder = 'products', string $disk = 'public'): string
    {
        $filename = Str::uuid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, $disk);
        return $path;
    }

    /**
     * Upload multiple images
     */
    public function uploadMultipleImages(array $files, string $folder = 'products', string $disk = 'public'): array
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->uploadImage($file, $folder, $disk);
            }
        }
        return $paths;
    }

    /**
     * Delete image
     */
    public function deleteImage(?string $path, string $disk = 'public'): bool
    {
        if (!$path) return false;
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        return false;
    }

    /**
     * Delete multiple images
     */
    public function deleteMultipleImages(?array $paths, string $disk = 'public'): void
    {
        if (!$paths) return;
        foreach ($paths as $path) {
            $this->deleteImage($path, $disk);
        }
    }

    /**
     * Update image (delete old, upload new)
     */
    public function updateImage(?string $oldPath, UploadedFile $newFile, string $folder = 'products', string $disk = 'public'): string
    {
        $this->deleteImage($oldPath, $disk);
        return $this->uploadImage($newFile, $folder, $disk);
    }

    /**
     * Get image URL
     */
    public function getImageUrl(?string $path, string $disk = 'public'): string
    {
        if (!$path) return asset('images/no-image.png');
        return Storage::disk($disk)->url($path);
    }
    /**
     * Download image from URL and save to storage
     */
    public function downloadImageFromUrl(string $url, string $folder = 'products', string $disk = 'public'): ?string
    {
        try {
            $contents = file_get_contents($url);
            if (!$contents) return null;

            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = Str::uuid() . '_' . time() . '.' . $extension;
            $path = $folder . '/' . $filename;

            Storage::disk($disk)->put($path, $contents);
            return $path;
        } catch (\Exception $e) {
            return null;
        }
    }


}
