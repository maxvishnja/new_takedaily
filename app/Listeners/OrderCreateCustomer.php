<?php

namespace App\Listeners;

use App\Events\CustomerWasBilled;

class OrderCreateCustomer
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CustomerWasBilled  $event
     * @return void
     */
    public function handle(CustomerWasBilled $event)
    {
		$event->customer->makeOrder($event->orderAmount, $event->stripeToken, null, $event->product, $event->balance, $event->balanceAmount, $event->coupon);
    }
}
