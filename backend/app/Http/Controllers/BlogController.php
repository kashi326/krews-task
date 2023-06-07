<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::paginate(15);
        return response()->json($blogs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'required|image',
        ]);

        $user = Auth::user();

        // Store the image in S3
        $imagePath = $request->file('image')->store('blog_images', 's3');
        if(!$imagePath){
            return response()->json(['image'=>'Image can\'t be uploaded'], 400);
        }
        $blog = Blog::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'image_path' => $imagePath,
            'user_id' => $user->id,
        ]);

        return response()->json($blog, 201);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->title = $request->input('title');
        $blog->body = $request->input('body');

        if ($request->hasFile('image')) {
            // Delete old image from S3
            Storage::disk('s3')->delete($blog->image_path);

            // Store the new image in S3
            $imagePath = $request->file('image')->store('blog_images', 's3');
            $blog->image_path = $imagePath;
        }

        $blog->save();

        return response()->json($blog);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Delete the image from S3
        Storage::disk('s3')->delete($blog->image_path);

        $blog->delete();

        return response()->json(null, 204);
    }
}
