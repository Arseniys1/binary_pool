<?php

namespace App\Providers;

use App\Helpers\StaticElements;
use Illuminate\Support\ServiceProvider;

class StaticElementsProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('StaticElements', function() {
            return new StaticElements();
        });
    }
}
