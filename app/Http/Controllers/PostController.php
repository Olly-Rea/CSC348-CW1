<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use App\Models\Post;

class PostController extends Controller
{

    /**
     * Method to return the post feed
     */
    public static function index() {
        // Get first 30 posts
        $posts = Post::orderBy('created_at', 'DESC')->paginate(30);
        // Return them in the feed view
        return view('feed', ['posts' => $posts]);
    }

    /**
     * Method to fetch the next page of paginated data
     */
    public function fetch(Request $request) {
        if ($request->ajax()) {
            // Get the next page of paginated posts
            $posts = Post::orderBy('created_at', 'DESC')->paginate(30);

            if(count($posts) == 0) {
                return null;
            } else {
                // render the posts and return them to the TalentFeed
                return view('paginations.posts', ['posts' => $posts])->render();
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to return the post feed
     */
    public static function show(Post $post) {
        // Return them in the feed view
        return view('blog', ['post' => $post]);
    }

}

