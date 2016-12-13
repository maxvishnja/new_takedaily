<?php

namespace App\Console;

use App\Console\Commands\GenerateSitemapCommand;
use App\Console\Commands\MailFlowSender;
use App\Console\Commands\NotifyPendingRebills;
use App\Console\Commands\SubscriptionRebillCommand;
use App\Console\Commands\UpdateAges;
use App\Console\Commands\UpdateCurrencies;
use App\Console\Commands\UpdatePregnancyWeeks;
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
		UpdateCurrencies::class,
		NotifyPendingRebills::class,
	    UpdateAges::class,
	    MailFlowSender::class,
		UpdatePregnancyWeeks::class
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
		$schedule->command('subscriptions:rebill')
		         ->name('rebill-subscribed-users')
		         ->everyThirtyMinutes()
		         ->withoutOverlapping();

		$schedule->command('currencies:update')
		         ->hourly();

		$schedule->command('subscriptions:pending')
		         ->name('notify-user-of-incoming-rebill')
		         ->dailyAt('09:00')
		         ->withoutOverlapping();

		$schedule->command('customers:age-update')
		         ->daily();

		$schedule->command('customers:pregnancy-update')
		         ->daily();

		$schedule->command('mailflow:send')
		         ->everyTenMinutes();

		$schedule->command('backup:run')
		         ->dailyAt('00:00');
	}
}
