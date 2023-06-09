<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;

class BlogController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $search = $request->get('search');

        $blogs = Blog::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            })
            ->latest('created_at')
            ->paginate(15);

        return $this->jsonResponse($blogs);
    }

    public function show($id): JsonResponse
    {
        $blog = Blog::findOrFail($id);
        return $this->jsonResponse($blog);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'required|min:10',
            'body' => 'required|min:10',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->title = $request->input('title');
        $blog->body = $request->input('body');

        if ($request->hasFile('image')) {
            $this->deleteOldImage($blog);

            $imagePath = ImageService::uploadImage($request->file('image'), 'blog_images');
            $blog->image_path = $imagePath;
        }

        $blog->save();

        return $this->jsonResponse($blog);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|min:10',
            'body' => 'required|min:10',
            'image' => 'required|image',
        ]);

        $user = Auth::user();

        $imagePath = ImageService::uploadImage($request->file('image'), 'blog_images');
        if (!$imagePath) {
            return $this->jsonResponse(['image' => 'Image can\'t be uploaded'], 400);
        }

        $blog = Blog::create([
            'id' => Blog::max('id') + 1,
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'image_path' => $imagePath,
            'user_id' => $user->id,
            'publish_date' => Carbon::now(),
        ]);

        return $this->jsonResponse($blog, 201);
    }

    public function destroy($id): JsonResponse
    {
        $blog = Blog::findOrFail($id);

        $this->deleteOldImage($blog);

        $blog->delete();

        return $this->jsonResponse(null, 204);
    }

    private function deleteOldImage(Blog $blog): void
    {
        ImageService::deleteImage($blog->image_path);
    }
}
