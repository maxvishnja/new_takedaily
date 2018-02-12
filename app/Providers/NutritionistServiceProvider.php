<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NutritionistServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Apricot\Interfaces\NutritionistRepositoryInterface', 'App\Apricot\Repositories\NutritionistRepository');
    }
}
