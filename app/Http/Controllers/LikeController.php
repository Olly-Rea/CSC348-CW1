<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\LikeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Method for a user to like a post.
     */
    public static function like(Request $request)
    {
        // Check that the request is ajax
        if ($request->ajax()) {
            // Ensure the user is logged in
            if (Auth::check()) {
                // Check what likeable object is being added
                if ($request->likeable_type === 'Post') {
                    // Get the post from the request
                    $toLike = Post::where('id', $request->likeable_id)->first();
                } elseif ($request->likeable_type === 'Comment') {
                    // Get the post from the request
                    $toLike = Comment::where('id', $request->likeable_id)->first();
                } else {
                    return 'Unrecognised likeable object!';
                }

                // See if the user is 'liking' or 'un-liking' this 'likeable' item
                $hasLike = $toLike->likes->contains(fn ($like) => $like->user_id === Auth::user()->id);
                if ($hasLike) {
                    // remove the post to the user's likes
                    $toLike->likes()->where('user_id', Auth::user()->id)->delete();
                } else {
                    // Add the 'Like' relationship
                    $like = $toLike->likes()->create([
                        'user_id' => Auth::user()->id,
                    ]);
                    // Notify the author of their content being liked
                    $likeable = $like->likeable;
                    $likeable->user->notify(new LikeNotification($likeable, $like->user));
                }
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }
}
