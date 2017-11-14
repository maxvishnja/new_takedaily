<?php

namespace App\Console;

use App\Console\Commands\ChangeAutomaticCoupon;
use App\Console\Commands\ClearOldCarts;
use App\Console\Commands\ClearSnoozing;
use App\Console\Commands\ClearOldSavedFlows;
use App\Console\Commands\DebugCommand;
use App\Console\Commands\GenerateSitemapCommand;
use App\Console\Commands\MailFlowSender;
use App\Console\Commands\NotifyPendingRebills;
use App\Console\Commands\SendHealthMail;
use App\Console\Commands\CheckGoalAmbassador;
use App\Console\Commands\CheckPayment;
use App\Console\Commands\SendToAlmost;
use App\Console\Commands\SubscriptionRebillCommand;
use App\Console\Commands\UpdateAges;
use App\Console\Commands\UpdateCurrencies;
use App\Console\Commands\ClearOldCoupons;
use App\Console\Commands\UpdateUserMail;
use App\Console\Commands\UpdatePregnancyWeeks;
use App\Console\Commands\AddCustomersToApi;
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
		SendToAlmost::class,
		UpdatePregnancyWeeks::class,
		CheckPayment::class,
	    ClearOldCarts::class,
	    ClearOldSavedFlows::class,
        ClearOldCoupons::class,
		ClearSnoozing::class,
		UpdateUserMail::class,
		DebugCommand::class,
		AddCustomersToApi::class,
		ChangeAutomaticCoupon::class,
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

		$schedule->command('almost:send')
					->weekly()->wednesdays()->at('09:00')
					->withoutOverlapping();

		$schedule->command('healthmail:send')
			     ->dailyAt('13:00');

        $schedule->command('api:add')
                    ->dailyAt('02:00');

		$schedule->command('check:ambassador')
			     ->dailyAt('09:00');

		/*$schedule->command('subscriptions:pending')
		         ->name('notify-user-of-incoming-rebill')
		         ->dailyAt('06:00')
			     ->everyThirtyMinutes()
		         ->withoutOverlapping(); */

		$schedule->command('customers:age-update')
		         ->daily();

        $schedule->command('clear:coupons')
            ->daily();

		$schedule->command('customers:pregnancy-update')
		         ->daily();

		$schedule->command('mailflow:send')
		         ->everyTenMinutes();

		$schedule->command('check:payment')
			->everyThirtyMinutes();

		$schedule->command('clear:flows')
		         ->monthly();

		$schedule->command('clear:carts')
		         ->dailyAt('00:20');

		$schedule->command('backup:run')
		         ->dailyAt('01:00');
	}
}
