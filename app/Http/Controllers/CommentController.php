<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use App\Models\Comment;

class CommentController extends Controller
{

    /**
     * Method to fetch a comment's replies
     */
    public function fetch(Request $request) {
        if ($request->ajax()) {
            // Get the next page of paginated replies
            $replies = Comment::where('id', '=', $request->id)->orderBy('created_at', 'DESC')->paginate(30);

            if(count($replies) == 0) {
                return null;
            } else {
                // render the replies and return them to the TalentFeed
                return view('paginations.replies', ['replies' => $replies])->render();
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

}
