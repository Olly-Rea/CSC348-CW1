<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

// Custom import
use App\Models\Likes;
use App\Models\Post;
use App\Models\User;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Calculate the number of possible user like combinations
        $userNum = count(User::get());
        $postNum = count(Post::get());
        $commentNum = count(Comment::get());

        // Use whichever of the two values is smaller
        $likesNum = ($userNum*$postNum)*0.8 < ($userNum*$commentNum)*0.8 ? round(($userNum*$postNum)*0.8) : round(($userNum*$commentNum)*0.8);

        // Call Comment factory
        Likes::factory($likesNum)->create();
    }
}
