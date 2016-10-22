<?php

namespace App\Providers;

use App\Plan;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Plan::deleting(function ($plan)
		{
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
