<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Custom import
use App\Models\Post;
use App\Models\Content;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Call on Post factory (with differing amounts of 'Content')
        Post::factory(48)->has(Content::factory(4))->create();
        Post::factory(32)->has(Content::factory(3))->create();
        Post::factory(20)->has(Content::factory(5))->create();
    }
}
