<?php

namespace App\Providers;

use App\OrderLine;
use App\OrderLineProduct;
use App\Product;
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

		Product::deleting(function ($product )
		{
			$product->planProducts()->delete();
			$product->orderLineProducts()->delete();
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
