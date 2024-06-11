<?php

namespace App\Providers;

use App\NewsContainer;
use App\PostNewsContainer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // register the NewsContainer
        app()->singleton('App\NewsContainer', fn () => new NewsContainer());

        // register the PostNewsContainer
        app()->singleton('App\PostNewsContainer', fn () => new PostNewsContainer());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        URL::forceScheme('https');
    }
}
