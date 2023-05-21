<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')
            || $this->app->environment('dev')
            || $this->app->environment('stage')
        ) {
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
