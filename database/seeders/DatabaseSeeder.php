<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's databases.
     *
     * @return void
     */
    public function run() {
        echo("\n");
        // Call on 'User' Seeder
        $this->call(UserSeeder::class);
        // Call on 'Post' Seeder (includes 'Content' seeding)
        $this->call(PostSeeder::class);
        // Call on 'Tag' Seeder
        $this->call(TagSeeder::class);
        // Call on 'Comment' Seeder
        $this->call(CommentSeeder::class);
        // Call on 'Comment' Seeder again; now including existing comments (create 'replies')
        $this->call(CommentSeeder::class);
        // Call on 'Likes' Seeder
        $this->call(LikesSeeder::class);
    }

}
