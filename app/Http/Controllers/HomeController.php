<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Custom import
use App\PostNewsContainer;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\NewsContainer;

class HomeController extends Controller
{
    // Variable for the number of News articles to get each time
    private $paginate = 12;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show() {
        // If authorised, go to main feed
        if(Auth::check()) {
            return redirect('/feed');
        } else {
            return view('welcome');
        }
    }

    /**
     * Method to show both news and posts on the feed 'home' page
     */
    public function index(PostNewsContainer $postNewsContainer, NewsContainer $newsContainer) {
        // Return the merged (and sorted) feedItems array
        return view('feed', ['requestFail' => $newsContainer->getRequestStatus(), 'feedItems' => $postNewsContainer->paginate(0, $this->paginate)]);
    }

    /**
     * Method to fetch the next page of all feed data
     */
    public function fetch(Request $request, PostNewsContainer $postNewsContainer) {
        // Check that the request is ajax
        if ($request->ajax()) {
            // Get the next page of paginated news
            $all = $postNewsContainer->paginate($request->page, $this->paginate);
            // If post&news != null and is > 0...
            if($all != null && count($all) > 0) {
                // render all the feedItems and return them to the feed
                return view('paginations.newsposts', ['feedItems' => $all])->render();
            } else {
                return null;
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }
}
