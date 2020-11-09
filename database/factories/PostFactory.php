<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

// Custom imports
use App\Models\User;

class PostFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Pick a random user from the list of all Users
        $user = User::inRandomOrder()->first();

        // Generate the created_at date... (must be after parent (user) created)
        $create_date = $this->faker->dateTimeBetween($startDate = $user->created_at, $endDate = 'now');
        // ...and (possibly) an updated_at date
        $update_date = null;
        // 50% chance of updated date
        if(rand(0,1) == 1) {
            $update_date = $this->faker->dateTimeThisYear();
        }

        // return new database record (row) to seed
        return [
            'userID' => $user->userID,
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->text(),
            'likes' => random_int(0, 500),
            'dislikes' => random_int(0, 500),
            // default 'Model' attributes for 'published' and 'edited'
            'created_at' => $create_date,
            'updated_at' => $update_date
        ];

    }
}
