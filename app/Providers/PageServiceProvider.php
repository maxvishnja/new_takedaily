<?php

namespace App\Providers;

use App\Page;
use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Page::deleting(function ($page)
		{
			$page->translations()->delete();
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
