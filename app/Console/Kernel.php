<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Console\Commands\SubscriptionRebillCommand;
use App\Console\Commands\GenerateSitemapCommand;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'subscriptions:rebill' => SubscriptionRebillCommand::class,
		'sitemap:generate'     => GenerateSitemapCommand::class
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

		$schedule->call('sitemap:generate')
				 ->weekly()
				 ->sundays()
				 ->at('00:00');
	}
}
