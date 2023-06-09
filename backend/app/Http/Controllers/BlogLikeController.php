<?php

namespace App\Http\Controllers;

use App\Models\BlogLike;
use Illuminate\Http\Request;

class BlogLikeController extends Controller
{
    public function store($blogId)
    {
        $userId = auth()->id();
        $like  = BlogLike::where([
            'user_id'=>$userId,
            'blog_id'=>$blogId
        ])->first();
        if ($like){
            $like->delete();
        }else{
            BlogLike::create([
                'user_id'=>$userId,
                'blog_id'=>$blogId
            ]);
        }
        return response()->json(['message'=>'success']);
    }
}
