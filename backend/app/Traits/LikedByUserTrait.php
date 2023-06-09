<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait LikedByUserTrait
{
    public function likedByUser($userId): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'blog_likes')->where('user_id', $userId);
    }
}
