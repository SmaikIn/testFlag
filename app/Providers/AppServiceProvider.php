<?php

namespace App\Providers;

use App\Domains\Shared\Hash\CustomHasher;
use Illuminate\Support\ServiceProvider;
use Meilisearch\Client as Meilisearch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Meilisearch::class, function () {
            $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
            $key = config('database.connections.documents.key');

            return new Meilisearch($host, $key);
        });

       /* $this->app->make('hash')->extend('custom', function () {
            return new CustomHasher();
        });*/
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
