<?php

namespace App;

use Illuminate\Support\Facades\Http;

class NewsContainer
{
    /**
     * My dev API Key for the NewsAPI API.
     *
     * @var string
     */
    protected $apiKey = '4b1d0df383d449a99063fbe36b01bede';
    /**
     * The array of news (required to reduce number of API requests).
     */
    protected $newsArray = [];
    /**
     * The current page number.
     *
     * @var int
     */
    private $page = 0;
    /**
     * The from date (a week ago) to use in the API request.
     *
     * @var string
     */
    private $from;
    /**
     * Boolean value to tell the application if the API request has failed.
     */
    protected $apiRequestFail = false;

    /**
     * Create a new container instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->from = strtotime('-1 week');
        // Set the URL to get the news from
        $url = 'https://newsapi.org/v2/everything?sources=bbc-news&from=' . $this->from . '&sortBy=popularity&pageSize=100&apiKey=' . $this->apiKey;
        // getData from the request method
        $this->newsArray = $this->getData($url);

        // If articles == null - varies based on API requests (~100 per day) - try the secondary API key
        if ($this->newsArray === null) {
            // Try again with secondary API key
            $this->apiKey = '5095fdf689bb420f9160938f75bb13f5';
            $url = 'https://newsapi.org/v2/everything?sources=bbc-news&from=' . $this->from . '&sortBy=popularity&pageSize=100&apiKey=' . $this->apiKey;
            // getData from the request method
            $this->newsArray = $this->getData($url);
        }

        // If articles != null
        if ($this->newsArray !== null) {
            // Return the formatted news
            $this->newsArray = $this->formatArray($this->newsArray);
        } else {
            $this->apiRequestFail = true;
        }
    }

    /**
     * Method to get all the news stories.
     */
    public function get()
    {
        // return the newsArray if it != null, otherwise return server error
        return $this->newsArray !== null ? $this->newsArray : null;
    }

    /**
     * Method to get x $num news articles at y $page.
     *
     * @param mixed $page
     * @param mixed $num
     */
    public function paginate($page, $num)
    {
        // Update the page number
        $this->page = $page;

        // Set the start index (page to start at)
        $startIndex = $page * $num;
        if (!$this->apiRequestFail) {
            // Get the page of news at that start index
            $newsPage = collect(\array_slice($this->newsArray, $startIndex, $num));
        }

        // return the newsPage if it != null, otherwise return server error
        return isset($newsPage) && $newsPage !== null ? $newsPage : null;
    }

    /**
     * Method to get data from the API request.
     *
     * @param mixed $url
     */
    private function getData($url)
    {
        // Get the response from the API request
        $response = Http::get($url);

        // return the JSON data
        return $response->json('articles');
    }

    /**
     * Method to format the data in the array of news articles.
     *
     * @param mixed $articles
     */
    private function formatArray($articles)
    {
        // Format the news array
        $articles = array_map(function ($article) {
            return [
                'type' => 'News',
                'author' => $article['author'] !== null ? $article['author'] : $article['source']['name'],
                // 'author' => $article['source']['name'],
                'title' => $article['title'],
                'description' => $article['description'],
                'url' => $article['url'],
                'urlToImage' => $article['urlToImage'],
                'created_at' => $article['publishedAt'],
                'content' => $article['content'],
            ];
        }, $articles);

        // Put the array in descending created_at timestamp order
        foreach ($articles as $key => $node) {
            $timestamps[$key] = $node['created_at'];
        }
        // Sort the array by timestamps
        array_multisort($timestamps, SORT_DESC, $articles);

        return $articles;
    }

    /**
     * Public method to return whether the API request has failed or not.
     */
    public function getRequestStatus()
    {
        return $this->apiRequestFail;
    }
}
