<?php

namespace App\Providers;

use App\Order;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::deleting( function ($order) {
			foreach($order->lines as $line)
			{
				$line->delete();
			}
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
