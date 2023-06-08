<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user with ID 1 if it doesn't exist
        User::firstOrCreate([
            'id' => 1
        ], [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);
    }

    public function testIndex()
    {
        Sanctum::actingAs(User::find(1));

        // Create sample blogs
        Blog::truncate();
        $blogs = Blog::factory()->count(10)->create();

        $response = $this->getJson('/api/blogs');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'body',
                        'image_path',
                        'user_id',
                        'publish_date',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function testShow()
    {
        Sanctum::actingAs(User::find(1));

        // Create a sample blog
        Blog::truncate();
        Blog::factory()->create();
        $blog = Blog::first();
        $response = $this->getJson('/api/blogs/' . $blog->id);
        $response->assertStatus(200)
            ->assertJson([
                'id' => $blog->id,
                'title' => $blog->title,
                'body' => $blog->body,
                'image_path' => $blog->image_path,
                'user_id' => $blog->user_id,
                'publish_date' => $blog->publish_date,
            ]);
    }

    public function testUpdate()
    {
        Sanctum::actingAs(User::find(1));

        // Create a sample blog
        Blog::factory()->create();
        $blog = Blog::first();

        // Mock image file
        $imageFile = UploadedFile::fake()->image('test_image.jpg');

        $response = $this->postJson('/api/blogs/' . $blog->id, [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
            'image' => $imageFile,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Title',
                'body' => 'Updated Body',
            ]);

        // Assert that the image was uploaded and saved
        $this->assertNotNull($response->json('image_path'));
        Storage::disk('s3')->assertExists($response->json('image_path'));
    }

    public function testStore()
    {
        Sanctum::actingAs(User::find(1));

        // Mock image file
        $imageFile = UploadedFile::fake()->image('test_image.jpg');

        $response = $this->postJson('/api/blogs', [
            'title' => 'Test Title Test Title Test Title',
            'body' => 'Test Body Test Body Test Body',
            'image' => $imageFile,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Test Title Test Title Test Title',
                'body' => 'Test Body Test Body Test Body',
            ]);

        // Assert that the image was uploaded and saved
        $this->assertNotNull($response->json('image_path'));
        Storage::disk('s3')->assertExists($response->json('image_path'));
    }

    public function testDestroy()
    {
        Sanctum::actingAs(User::find(1));

        // Create a sample blog
        Blog::factory()->create();
        $blog = Blog::first();
        $response = $this->deleteJson('/api/blogs/' . $blog->id);

        $response->assertStatus(204);

    }
}
