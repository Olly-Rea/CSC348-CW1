<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Custom imports
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's databases.
     *
     * @return void
     */
    public function run() {
        // Call User factory
        User::factory(50)->create();
        // Call Post factory
        Post::factory(80)->create();
        // Call Comment factory
        Comment::factory(120)->create();
        // Call Reply factory
        Reply::factory(60)->create();
    }

}
