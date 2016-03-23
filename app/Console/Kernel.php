<?php

namespace App\Console;

use App\Console\Commands\GenerateSitemapCommand;
use App\Console\Commands\SubscriptionRebillCommand;
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
		GenerateSitemapCommand::class
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
				 ->dailyAt('12:00');
	}
}
