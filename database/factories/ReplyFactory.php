<?php

namespace Database\Factories;

use App\Models\Reply;
use Illuminate\Database\Eloquent\Factories\Factory;

// Custom imports
use App\Models\Comment;
use App\Models\User;

class ReplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Pick a random User from the list of all Users
        $user = User::inRandomOrder()->first();
        // Pick a random Post from the list of all Posts
        $comment = Comment::inRandomOrder()->first();

        // Generate the created_at date... (must be after parent (comment) created)
        $create_date = $this->faker->dateTimeBetween($startDate = $comment->created_at, $endDate = 'now');
        // ...and (possibly) an updated_at date
        $update_date = null;
        // 50% chance of updated date
        if(rand(0,1) == 1) {
            $update_date = $this->faker->dateTimeThisYear();
        }

        // return new database record (row) to seed
        return [
            'user_id' => $user->user_id,
            'comment_id' => $comment->comment_id,
            'content' => $this->faker->text(),
            'likes' => random_int(0, 500),
            'dislikes' => random_int(0, 500),
            // default 'Model' attributes for 'published' and 'edited'
            'created_at' => $create_date,
            'updated_at' => $update_date
        ];
    }
}
