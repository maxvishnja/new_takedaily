<?php

namespace App\Console;

use App\Console\Commands\GenerateSitemapCommand;
use App\Console\Commands\SubscriptionRebillCommand;
use App\Console\Commands\UpdateCurrencies;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		SubscriptionRebillCommand::class,
		UpdateCurrencies::class
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 *
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->call('subscriptions:rebill')
			->name('rebill-subscribed-users')
			->everyThirtyMinutes()
			->withoutOverlapping();

		$schedule->call('currencies:update')
			->hourly();
	}
}
