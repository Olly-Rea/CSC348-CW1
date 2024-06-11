<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Database\Factories\TagFactory;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Get tags from Helper function
        $tags = \count(TagFactory::getTags());
        // Seed Tag Database
        Tag::factory($tags)->create();

        // Seed post_tags Database
        foreach (Post::get() as $post) {
            // Define the empty postTags array
            $postTags = [];
            // For a random number of tags (0 to 6)
            for ($i = 0; $i < random_int(0, 4); ++$i) {
                // Get a unique tag
                do {
                    $tag = Tag::inRandomOrder()->first();
                } while (\in_array($tag, $postTags));
                // Add to array
                array_push($postTags, $tag);

                // Sync the tags with the post in the post_tags pivot table ("false" = don't drop exisitng tags)
                $post->tags()->attach($tag);
            }
        }
    }
}
