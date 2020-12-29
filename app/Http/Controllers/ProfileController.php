<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;

class ProfileController extends Controller
{

    /**
     * Method to load the profile image for a 'User' model
     */
    public static function loadImage($path) {
        $imagePath = 'storage'.DIRECTORY_SEPARATOR.$path;
        // Check the file exists, and if so, output it, otherwise, return the image placeholder
        if (file_exists(public_path().DIRECTORY_SEPARATOR.$imagePath)) {
            return asset($imagePath);
        } else {
            clearstatcache();
            return asset('/images/profile-default.png');
        }
    }

    /**
     * Method to show a User's profile
     */
    public static function show(User $user) {
        if(Auth::check() && Auth::user()->id == $user->id) {
            return redirect('/Me');
        } else {
            return view('profile', ['user' => $user]);
        }

    }

    /**
     * Method to show the Auth User's profile
     */
    public static function me() {
        if (Auth::check()) {
            return view('profile', ['user' => Auth::user()]);
        } else {
            abort(404);
        }
    }

    /**
     * Method to fetch a profile's about info
     */
    public static function fetchAbout(Request $request) {
        if ($request->ajax()) {

        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to fetch a User's posts
     */
    public static function fetchPosts(Request $request) {
        if ($request->ajax()) {
            // Get the next page of this users paginated posts
            $user = User::where('id', $request->user_id)->first();
            $posts = $user->posts->orderBy('created_at', 'DESC')->paginate(12);

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

    // /**
    //  * Method to fetch all the User's likeable elements
    //  */
    // public static function fetchLikes(Request $request) {
    //     if ($request->ajax() && strpos($request->url(), 'Me') != false) {

    //         // Get the next page of this users paginated posts
    //         $posts = Auth::user()->posts->orderBy('created_at', 'DESC')->paginate(12);

    //         if(count($posts) == 0) {
    //             return null;
    //         } else {
    //             // render the posts and return them to the TalentFeed
    //             return view('paginations.posts', ['posts' => $posts])->render();
    //         }
    //     // Else return a 404 not found error
    //     } else {
    //         abort(404);
    //     }
    // }

}
