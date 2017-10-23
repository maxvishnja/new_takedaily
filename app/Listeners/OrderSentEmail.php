<?php

namespace App\Listeners;

use App\Events\SentMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSentEmail
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
     * @param  SentMail  $event
     * @return void
     */
    public function handle(SentMail $event)
    {
        //
    }
}
