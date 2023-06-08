<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $user = User::first();
        for ($i = 0; $i < 1000; $i++) {
            Blog::create([
                'title' => $faker->sentence,
                'body' => $faker->paragraphs(3, true),
                'image_path' => 'blog_images/nmOt3Rbn6R9Ck5bkkaaSwXfWVwe14Cs982ONVDA4.jpg',
                'user_id' => $user->id
            ]);
        }
    }
}
