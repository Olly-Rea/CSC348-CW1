<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use App\Models\Post;

class SearchController extends Controller
{

    /**
     * Method to search for specific posts
     */
    public function search(Request $request) {
        // Get first 30 posts
        $posts = Post::with('tags')->where('tags', $request->tags)->orderBy('created_at', 'DESC')->paginate(30);
        // Return them in the feed view
        return view('feed', ['posts' => $posts]);
    }

    /**
     * Method to display the first 30 of a refined feed of posts
     */
    public function refine(Request $request) {
        // Get first 30 posts
        $posts = Post::with('tags')->where('tags', $request->tags)->orderBy('created_at', 'DESC')->paginate(30);
        // Return them in the feed view
        return view('feed', ['posts' => $posts]);
    }

    /**
     * Method to fetch the next page of paginated data (specific to search)
     */
    public function fetch(Request $request) {
        if ($request->ajax()) {
            // Convert the request query (form data) to a new instance of Request
            $formRequest = new Request($request->query());
            // Set the profile collection based on the users request (and paginate)
            $posts = $this->getposts($formRequest)->paginate(30);
            // Check this page of the collection isn't empty
            if(count($posts) == 0) {
                return null;
            } else {
                // render the posts and return them to the TalentFeed
                return view('components.paginate', ['posts' => $posts])->render();
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

}
