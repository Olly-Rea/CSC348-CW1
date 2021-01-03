<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom imports
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;
use App\Notifications\CommentNotification;

class CommentController extends Controller
{

    /**
     * Method to fetch a comment's replies
     */
    public function fetch(Request $request) {
        // Check that the request is ajax
        if ($request->ajax()) {
            // Get the next page of paginated replies
            $replies = Comment::find($request->id)->replies;//()->orderBy('created_at', 'DESC')->paginate(30);

            // $replies = $replies->orderBy('created_at', 'DESC')->paginate(30);
            // $replies = Comment::where('commentable_type', 'App\Models\Comment')->where('commentable_id', $request->id)->orderBy('created_at', 'DESC')->paginate(30);

            if(count($replies) == 0) {
                return null;
            } else {
                // render the replies and return them to the current page
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
                // Notify the author of their content being commented on / replied to
                $commentable = $comment->commentable;
                $commentable->user->notify(new CommentNotification($commentable, $comment->user));
                // Render new comment
                return view('paginations.comments', ['comments' => $comment])->render();
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to update a User's comment
     */
    public static function update(Request $request) {
        // Check that the request is ajax
        if ($request->ajax()) {
            // Ensure the user is logged in
            if(Auth::check()) {
                // Get the comment to edit
                $comment = Auth::user()->comments()->where('id', $request->id)->first();
                // Check the the user does in fact have acces to this comment
                if($comment != null) {
                    // Update the comment
                    $comment->update([
                        'content' => $request->val
                    ]);
                    // return success
                    return true;
                } else {
                    // Return 'issue'
                    return false;
                }
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to delete a User's comment
     */
    public static function delete(Request $request) {
        // Check that the request is ajax
        if ($request->ajax()) {
            // Ensure the user is logged in
            if(Auth::check()) {
                // Get the comment to edit
                $comment = Auth::user()->comments()->where('id', $request->id)->first();
                // Check the the user does in fact have acces to this comment
                if($comment != null) {
                    // Delete all the likes on this comment and those on the comment's replies
                    $comment->likes()->delete();
                    foreach($comment->replies as $reply) {
                        $reply->likes()->delete();
                    }
                    // Delete the comment's replies
                    $comment->replies()->delete();
                    // Delete the comment
                    $comment->delete();
                    // return success
                    $success = true;
                } else {
                    // Return 'issue'
                    $success = false;
                }
                return $success;
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

}
