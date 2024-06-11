<?php

namespace App\Http\Controllers;

use App\NewsContainer;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // Variable for the number of News articles to get each time
    private $paginate = 12;

    /**
     * Method to return news articles from the NewsAPI web resource.
     */
    public function index(NewsContainer $newsContainer)
    {
        // Return the news 'index' view
        return view('news.index', ['requestFail' => $newsContainer->getRequestStatus(), 'news' => $newsContainer->paginate(0, $this->paginate)]);
    }

    /**
     * Method top fetch the next page of collection data.
     */
    public function fetch(Request $request, NewsContainer $newsContainer)
    {
        // Check that the request is ajax
        if ($request->ajax()) {
            // Get the next page of paginated news
            $news = $newsContainer->paginate($request->page, $this->paginate);
            // If $news != null and is > 0...
            if ($news !== null && \count($news) > 0) {
                // ...render the News articles and return them to the feed
                return view('paginations.news', ['news' => $news])->render();
            } else {
                return null;
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }
}
