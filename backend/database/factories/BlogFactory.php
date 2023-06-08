<?php

namespace Database\Factories;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        return [
            'id'=>Blog::max('id')+1,
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(3, true),
            'image_path' => 'blog_images/nmOt3Rbn6R9Ck5bkkaaSwXfWVwe14Cs982ONVDA4.jpg',
            'user_id' => 1, // Replace with the appropriate user ID
            'publish_date' => Carbon::now()->subDays(rand(0,1200)),
        ];
    }
}
