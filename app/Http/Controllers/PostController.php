<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Method to load images for image-type 'Content'
     */
    public static function loadImage($path) {
        $imagePath = 'storage'.DIRECTORY_SEPARATOR.$path;
        // Check the file exists, and if so, output it, otherwise, return the image placeholder
        if (file_exists(public_path().DIRECTORY_SEPARATOR.$imagePath)) {
            return asset($imagePath);
        } else {
            clearstatcache();
            return asset('/images/graphics/image.svg');
        }
    }

    /**
     * Method to return the post feed
     */
    public static function index() {
        // Get first 30 posts
        $posts = Post::orderBy('created_at', 'DESC')->paginate(12);
        // Return them in the feed view
        return view('feed', ['posts' => $posts]);
    }

    /**
     * Method to fetch the next page of paginated data
     */
    public function fetch(Request $request) {
        if ($request->ajax()) {
            // Get the next page of paginated posts
            $posts = Post::orderBy('created_at', 'DESC')->paginate(12);

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

    /**
     * Method for a user to like a post
     */
    public static function like(Request $request) {
        // Check that the request is ajax
        if ($request->ajax()) {
            // Ensure a user is logged in
            if(Auth::check()) {
                // Get the post from the request
                $likeable = Post::where('id', $request->post_id)->first();

                // See if the user is 'liking' or 'un-liking' a likeable item
                if(Auth::user()->likes->has($request->post_id)) {
                    // remove the post to the user's likes
                    Auth::user()->likes->remocve($request->post_id);
                } else {
                    // Add the post to the user's likes
                    Auth::user()->likes->attach($request->post_id);
                }
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

}

