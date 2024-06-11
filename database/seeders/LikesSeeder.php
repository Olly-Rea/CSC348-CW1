<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Likes;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Calculate the number of possible user like combinations
        $userNum = \count(User::get());
        $postNum = \count(Post::get());
        $commentNum = \count(Comment::get());
        // percentage of the total calculated number to use
        $percent_val = 0.9;

        // Use whichever of the two values is smaller
        $likesNum = ($userNum * $postNum) * $percent_val < ($userNum * $commentNum) * $percent_val ? round(($userNum * $postNum) * $percent_val) : round(($userNum * $commentNum) * $percent_val);

        // Call Comment factory
        Likes::factory($likesNum)->create();
    }
}
