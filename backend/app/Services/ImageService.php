<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function uploadImage($file, $directory): ?string
    {
        if (!$file->isValid()) {
            return null;
        }

        return $file->store($directory, 's3');
    }

    public static function deleteImage($imagePath): void
    {
        Storage::disk('s3')->delete($imagePath);
    }
}
