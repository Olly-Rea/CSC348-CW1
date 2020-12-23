<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    // Method to return the tags for the website
    public static function getTags() {
        return ['Work', 'Technology', 'Home', 'Leisure', 'DIY', 'Health', 'Cooking', 'Gaming', 'NSFW'];
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        // return new database record (row) to seed
        return [
            // Seed the array of tags
            'name' => $this->faker->unique()->randomElement($this->getTags()),
        ];
    }

}
