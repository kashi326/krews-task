<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;

    protected $appends = ['image_link','owned'];
    protected $fillable = [
        'id',
        'title',
        'body',
        'image_path',
        'user_id'
    ];

    public function getImageLinkAttribute()
    {
        return Storage::disk('s3')->temporaryUrl($this->image_path, now()->addHour());
    }
    public function getOwnedAttribute()
    {
        return auth()->check() && $this->user_id === auth()->id();
    }
}
