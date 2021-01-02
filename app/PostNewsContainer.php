<?php

namespace App;

use Illuminate\Http\Request;

// Custom import
use Illuminate\Support\Facades\Http;
use App\Models\Post;


class PostNewsContainer
{

    // TODO Create BIG feed of all stuff and then sort and paginate

    /**
     * Big ol' array to store all the feed stuff (ready to be paginated)
     */
    protected $feedArray = [];
    /**
     * The current page number
     *
     * @var int
     */
    private $page;

    /**
     * Create a new container instance.
     *
     * @return void
     */
    public function __construct() {
        // Get ALL the news
        $news = app()->make('App\NewsContainer')->get();
        // Get the first page of posts (as a array instance)
        $posts = Post::get()->toArray();

        if($news != null) {
            // Sort the array by date created_at
            $this->feedArray = $this->mergeArraysByDate($news, $posts);
        } else {
            $this->feedArray = $posts;
        }
    }

    /**
     * Method to get x $num news articles at y $page
     */
    public function paginate($page, $num) {
        // Set the start index (page to start at)
        $startIndex = $page * $num;
        // Get the page of news at that start index
        $newsPosts = collect(array_slice($this->feedArray, $startIndex, $num));
        // Return the page of news & posts
        return $newsPosts;
    }

    private function mergeArraysByDate($news, $posts) {
        // Merge the two arrays
        $all = array_merge($news, $posts);
        // get the timestamps for all the array elements
        foreach ($all as $key => $node) {
            $timestamps[$key] = $node["created_at"];
        }
        // Sort the array by timestamps
        array_multisort($timestamps, SORT_DESC, $all);
        // Return the sorted array (as collection instance)
        return $all;
    }




}
