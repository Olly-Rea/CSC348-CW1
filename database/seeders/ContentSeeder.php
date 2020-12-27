<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

// Custom import
use App\Models\Post;
use Illuminate\Support\Facades\File;

class ContentSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Loop through all posts and create content for it
        foreach(Post::get('id') as $post) {
            // Add between 1 and 6 new content to each post
            for($i = 0; $i < rand(1,6); $i++) {
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
                    $content = $this->faker->paragraph();
                    // if(rand(0,1) == 1) {
                    //     $sub_content = $this->faker->sentence();
                    // }
                } else {
                    $basePath = '/public/demo/';
                    $fileNames =  File::files('/public/demo/');
                    $content = $basePath . $fileNames[[rand(0, count($fileNames))]]; // Full image path
                    // 50% chance of image having caption
                    if(rand(0,1) == 1) {
                        $sub_content = $this->faker->sentence();
                    }
                }
                // Create the new content
                Content::create([
                    'post_id' => $post,
                    'position' => $i,
                    'content_type' => $content_type,
                    'content' => $content,
                    'sub_content' => $sub_content
                ]);
            }
        }
    }
}
