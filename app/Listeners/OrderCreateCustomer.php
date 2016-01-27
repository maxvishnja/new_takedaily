<?php

namespace App\Listeners;

use App\Events\CustomerWasBilled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
		$event->customer->makeOrder($event->orderAmount, $event->stripeToken);
    }
}
