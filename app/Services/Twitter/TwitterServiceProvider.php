<?php

namespace App\Services\Twitter;

use Illuminate\Console\Application;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TwitterOAuth::class, function () {
            return new TwitterOAuth(
                (string) config('services.twitter.consumer_key'),
                (string) config('services.twitter.consumer_secret'),
                (string) config('services.twitter.access_token'),
                (string) config('services.twitter.access_token_secret'),
            );
        });

        $this->app->bind(TwitterClientInterface::class, function (Application $app) {
            if ($app->environment() === 'production') {
                return app(TwitterClient::class);
            }

            return new NullTwitterClient();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
