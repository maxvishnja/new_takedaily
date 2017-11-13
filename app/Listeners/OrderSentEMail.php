<?php

namespace App\Listeners;

use App\Events\SentMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSentEMail implements ShouldQueue
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
    public function handle( SentMail $event )
    {

        try {

            $order = $event->order;
            $order->sendEmail($event->status );

        } catch (\Exception $exception) {

            \Log::error($exception->getFile() . " on line " . $exception->getLine());

            \Log::error($exception->getTraceAsString());

        }
    }
}
