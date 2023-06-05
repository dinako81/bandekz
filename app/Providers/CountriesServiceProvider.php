<?php

namespace App\Providers;

use App\Services\CountriesService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class CountriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CountriesService::class, function ($app) {
            return new CountriesService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}