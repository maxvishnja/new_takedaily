<?php

namespace App\Providers;

use App\OrderLine;
use Illuminate\Support\ServiceProvider;

class OrderLineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        OrderLine::deleting(function ($orderLine) {
			$orderLine->products()->delete();
		});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
