<?php

namespace App\Models;

use App\Services\BlogService;
use App\Traits\LikedByUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, LikedByUserTrait;

    protected $appends = ['image_link', 'owned', 'liked'];
    protected $fillable = [
        'id',
        'title',
        'body',
        'image_path',
        'user_id',
        'publish_date'
    ];

    public function getImageLinkAttribute(): string
    {
        return BlogService::getImageLink($this->image_path);
    }

    public function getOwnedAttribute(): bool
    {
        $userId = auth()->id();
        return BlogService::isOwnedByUser($userId, $this->user_id);
    }

    public function getLikedAttribute(): bool
    {
        $userId = auth()->id();
        return $this->likedByUser($userId)->exists();
    }
}
