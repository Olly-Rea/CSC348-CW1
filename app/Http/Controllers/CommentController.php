<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    /**
     * Method to fetch a comment's replies
     */
    public function fetch(Request $request) {
        if ($request->ajax()) {
            // Get the next page of paginated replies
            $replies = Comment::find($request->id)->replies;//()->orderBy('created_at', 'DESC')->paginate(30);

            // $replies = $replies->orderBy('created_at', 'DESC')->paginate(30);
            // $replies = Comment::where('commentable_type', 'App\Models\Comment')->where('commentable_id', $request->id)->orderBy('created_at', 'DESC')->paginate(30);

            if(count($replies) == 0) {
                return null;
            } else {
                // render the replies and return them to the TalentFeed
                return view('paginations.comments', ['comments' => $replies])->render();
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to create a new Comment
     */
    public function create(Request $request) {
        // Check that the request is ajax
        if ($request->ajax()) {
            // Ensure the user is logged in
            if(Auth::check()) {
                // Set Validator attribute names
                $attributeNames = array(
                    'content' => 'Comment'
                );
                // Validate the data
                Validator::make($request->all(), [
                    'content' => ['required', 'string']
                ], [], $attributeNames)->validate();

                // TODO Add language check (from Helpers function)

                // Add new comment
                $comment = Comment::create([
                    'user_id' => Auth::user()->id,
                    'commentable_type' => 'App\Models\\'.$request->commentable_type,
                    'commentable_id' => $request->commentable_id,
                    'content' => $request->content,
                ]);
                // Render new comment
                return view('paginations.comments', ['comments' => $comment])->render();
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }


}
