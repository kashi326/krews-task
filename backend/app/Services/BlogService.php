<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    public static function getImageLink(string $imagePath): string
    {
        return Storage::disk('s3')->temporaryUrl($imagePath, now()->addHour());
    }

    public static function isOwnedByUser(int $userId, int $ownerId): bool
    {
        return $userId === $ownerId;
    }
}
