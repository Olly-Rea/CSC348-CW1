<?php

namespace Database\Factories;

use App\Helpers;
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

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        // return new database record (row) to seed
        return [
            // Seed the array of tags
            'name' => $this->faker->unique()->sentence(random_int(1,2)),
        ];
    }
}
