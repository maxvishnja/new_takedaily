<?php

namespace App\Providers;

use App\Apricot\Libraries\MailFlowMatchmaker;
use App\Customer;
use App\MailFlow;
use App\Plan;
use App\User;
use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		User::created( function ( $user )
		{
			if ( $user->type == 'user' )
			{
				$customer = new Customer();

				$customer->user_id           = $user->id;
				$customer->plan_id           = Plan::create()->id;
				$customer->accept_newletters = 1;
				$customer->locale            = \App::getLocale();

				$customer->save();

				$mailflows = MailFlow::where( 'should_auto_match', 1 )->get();
				$matcher   = new MailFlowMatchmaker();

				/** @var MailFlow $mailflow */
				foreach ( $mailflows as $mailflow )
				{
					if ( $matcher->make( $mailflow, $customer, true ) )
					{
						$mailflow->match( $customer );
					}
				}
			}
		} );

		User::deleting( function ( $user )
		{
			$user->customer->delete();
		} );
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
