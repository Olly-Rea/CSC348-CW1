<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

// Custom import
use App\Models\Post;

class ContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Content::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Pick a random user from the list of all Users
        $post = Post::withCount('content')->inRandomOrder()->first();
        // Get the position for the content
        $position = $post->count('content_count');
        // Set the 'content_type' of the content
        if(rand(1,3) > 1) {
            $content_type = 'text';
        } else {
            $content_type = 'image';
        }
        // Set the 'content' of the content (based on content_type)
        if($content_type == 'text') {
            $content = $this->faker->paragraph();
        } else {
            $content = 'Example image URL';
        }

        return [
            'post_id' => $post->id,
            'position' => $position,
            'content_type' => $content_type,
            'content' => $content,
            // 'sub_content' => $sub_content
        ];
    }
}
