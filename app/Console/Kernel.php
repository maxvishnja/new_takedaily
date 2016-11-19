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
		$schedule->call('subscriptions:rebill')
		         ->name('rebill-subscribed-users')
		         ->everyThirtyMinutes()
		         ->withoutOverlapping();

		$schedule->call('currencies:update')
		         ->hourly();

		$schedule->call('subscriptions:pending')
		         ->name('notify-user-of-incoming-rebill')
		         ->hourly()
		         ->withoutOverlapping();

		$schedule->call('customers:age-update')
		         ->daily();

		$schedule->call('customers:pregnancy-update')
		         ->daily();

		$schedule->call('mailflow:send')
		         ->everyTenMinutes();
	}
}
