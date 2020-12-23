<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Custom import
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Call Post factory
        Post::factory(80)->create();
    }
}
