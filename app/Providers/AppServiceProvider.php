<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Custom import
use App\NewsContainer;
use App\PostNewsContainer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // register the NewsContainer
        app()->singleton('App\NewsContainer', function() {
            return new NewsContainer;
        });

        // register the PostNewsContainer
        app()->singleton('App\PostNewsContainer', function() {
            return new PostNewsContainer;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
