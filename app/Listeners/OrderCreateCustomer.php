<?php

namespace App\Listeners;

use App\Customer;
use App\Events\CustomerWasBilled;

class OrderCreateCustomer
{
	/**
	 * Create the event listener.
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  CustomerWasBilled $event
	 *
	 * @return void
	 */
	public function handle( CustomerWasBilled $event )
	{
		\Log::info( $event->customerId );
		$customer = Customer::find( $event->customerId );

		$customer->makeOrder( $event->orderAmount, $event->chargeToken, null, $event->product, $event->balance, $event->balanceAmount, $event->coupon, $event->gift );
	}
}
