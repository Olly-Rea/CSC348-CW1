<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom imports
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;

class PostController extends Controller
{

    /**
     * Method to return the post feed
     */
    public function index() {

        $posts = Post::orderBy('created_at', 'DESC')->get();
        $comments = Comment::orderBy('created_at')->get();
        $replies = Reply::orderBy('created_at')->get();

        return view('feed', ['posts' => $posts, 'comments' => $comments, 'replies' => $replies]);
    }

}
