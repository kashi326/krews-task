<?php

namespace Tests\Unit;

use App\Http\Controllers\BlogLikeController;
use App\Models\Blog;
use App\Models\BlogLike;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class BlogLikeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreWithExistingLike()
    {
        // Create a user
        $user = $this->createUser();

        // Create a blog
        $blog = $this->createBlog();

        // Create a like for the user and blog
        $like = BlogLike::create([
            'user_id' => $user->id,
            'blog_id' => $blog->id,
        ]);

        // Set the authenticated user
        Auth::shouldReceive('id')->andReturn($user->id);

        // Create an instance of the controller
        $controller = new BlogLikeController();

        // Call the store method
        $response = $controller->store($blog->id);

        // Assert that the like was deleted
        $this->assertDatabaseMissing('blog_likes', [
            'id' => $like->id,
        ]);

        // Assert the response
        $this->assertEquals(ResponseAlias::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(['message' => 'success'], $response->getData(true));
    }

    protected function createUser()
    {
        User::firstOrCreate([
            'id' => 1
        ], [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);
        return User::first();
    }

    protected function createBlog()
    {
        // Create a blog
        Blog::factory()->create();
        return Blog::first();
    }

    public function testStoreWithNewLike()
    {
        // Create a user
        $user = $this->createUser();

        // Create a blog
        $blog = $this->createBlog();

        // Set the authenticated user
        Auth::shouldReceive('id')->andReturn($user->id);

        // Create an instance of the controller
        $controller = new BlogLikeController();

        // Call the store method
        $response = $controller->store($blog->id);

        // Assert that the like was created
        $this->assertDatabaseHas('blog_likes', [
            'user_id' => $user->id,
            'blog_id' => $blog->id,
        ]);

        // Assert the response
        $this->assertEquals(ResponseAlias::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(['message' => 'success'], $response->getData(true));
    }
}
