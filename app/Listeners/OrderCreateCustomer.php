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

		try {

		\Log::info( $event->customerId );

		$customer = Customer::find( $event->customerId );
		$customer->makeOrder( $event->orderAmount, $event->chargeToken, null, $event->product, $event->balance, $event->balanceAmount, $event->coupon, $event->gift, $event->order_plan, $event->repeat );

		} catch (\Exception $exception) {

			\Log::error($exception->getFile() . " on line " . $exception->getLine());

			\Log::error($exception->getTraceAsString());

		}
	}
}
