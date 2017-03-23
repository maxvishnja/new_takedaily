<?php

namespace App\Console;

use App\Console\Commands\ClearOldCarts;
use App\Console\Commands\ClearSnoozing;
use App\Console\Commands\ClearOldSavedFlows;
use App\Console\Commands\GenerateSitemapCommand;
use App\Console\Commands\MailFlowSender;
use App\Console\Commands\NotifyPendingRebills;
use App\Console\Commands\SendHealthMail;
use App\Console\Commands\CheckGoalAmbassador;
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
	    SendHealthMail::class,
		CheckGoalAmbassador::class,
		UpdatePregnancyWeeks::class,
	    ClearOldCarts::class,
	    ClearOldSavedFlows::class,
		ClearSnoozing::class
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

		$schedule->command('healthmail:send')
			     ->dailyAt('13:00');

		$schedule->command('subscriptions:pending')
		         ->name('notify-user-of-incoming-rebill')
		         ->dailyAt('06:00')
		         ->withoutOverlapping();

		$schedule->command('customers:age-update')
		         ->daily();

		$schedule->command('customers:pregnancy-update')
		         ->daily();

		$schedule->command('mailflow:send')
		         ->everyTenMinutes();

		$schedule->command('clear:flows')
		         ->dailyAt('00:00');

		$schedule->command('clear:carts')
		         ->dailyAt('00:20');

		$schedule->command('backup:run')
		         ->dailyAt('01:00');
	}
}
