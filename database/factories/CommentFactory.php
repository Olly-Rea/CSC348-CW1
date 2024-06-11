<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // Pick a random User from the list of all Users
        $user = User::inRandomOrder()->first();

        // Add the comment to either a post or another comment (as a 'reply'); the first run of this class
        // creates no replies, hence the structure of this code (and that this factory is called twice).
        $commentable = Comment::inRandomOrder()->first();
        // If no comments exist to reply to, create another post comment,
        if ($commentable === null) {
            $commentable = Post::inRandomOrder()->first();
        }

        // get the class type of the 'commentable' object
        $type = $commentable::class;

        // Generate the created_at date... (must be after the parent was created)
        $create_date = $this->faker->dateTimeBetween($startDate = $commentable->created_at, $endDate = 'now');
        // ...and (possibly) an updated_at date
        $update_date = null;
        // 50% chance of updated date
        if (random_int(0, 1) === 1) {
            $update_date = $this->faker->dateTimeThisYear();
        }

        // return new database record (row) to seed
        return [
            'user_id' => $user->id,
            'commentable_id' => $commentable->id,
            'commentable_type' => $type,
            'content' => $this->faker->text($maxNbChars = random_int(120, 400)),
            // default 'Model' attributes for 'published' and 'edited'
            'created_at' => $create_date,
            'updated_at' => $update_date,
        ];
    }
}
