<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Likes;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Likes::class;

    // Define the User Pairings to track
    private $likePairing = [];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // Loop until a unique pairing is made
        do {
            // Pick a random pairing of a user and a post from the list of all Users and Posts
            $user_id = User::inRandomOrder()->first()->id;

            $chance = random_int(1, 10);
            // Add the comment to either a post or another comment (as a 'reply') - 40% chance
            if ($chance <= 4) {
                $likeable = Comment::inRandomOrder()->first();
            }
            // If no comments exist to reply to, create another post comment - 60% chance
            if ($chance > 4 || $likeable === null) {
                $likeable = Post::inRandomOrder()->first();
            }

            // get the class type of the 'likeable' object
            $type = $likeable::class;
        } while (\in_array([$user_id, $type, $likeable->id], $this->likePairing));

        // Add the unique pairing to the array
        array_push($this->likePairing, [$user_id, $type, $likeable->id]);

        return [
            'user_id' => $user_id,
            'likeable_id' => $likeable->id,
            'likeable_type' => $type,
        ];
    }
}
