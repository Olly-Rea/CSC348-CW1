<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Custom import
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Call Comment factory
        Comment::factory(200)->create();
    }
}
