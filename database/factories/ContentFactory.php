<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

// Custom import
use Illuminate\Support\Facades\Storage;
// use App\Models\Post;

class ContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Content::class;

    private $position = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Set the 'content_type' of the content
        if(rand(1,3) > 1) {
            $content_type = 'text';
        } else {
            $content_type = 'image';
        }

        // Set sub_content as null
        $sub_content = null;

        // Set the 'content' of the content (based on content_type)
        if($content_type == 'text') {
            $content = $this->faker->paragraph($maxNbChars = rand(8, 32));
            // if(rand(0,1) == 1) {
            //     $sub_content = $this->faker->sentence();
            // }
        } else {
            $demoFiles = Storage::files('/demo_images');
            $content = $demoFiles[rand(0, count($demoFiles)-1)]; // Full image path
            // 50% chance of image having caption
            if(rand(0,1) == 1) {
                $sub_content = $this->faker->sentence();
            }
        }

        return [
            // 'post_id' => $post->id,
            'position' => $this->position++,
            'type' => $content_type,
            'content' => $content,
            'sub_content' => $sub_content
        ];

    }
}
