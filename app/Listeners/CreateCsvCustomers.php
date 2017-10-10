<?php

namespace App\Listeners;

use App\Events\CreateCsv;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateCsvCustomers implements ShouldQueue
{

    use InteractsWithQueue;

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
     * @param  CreateCsv  $event
     * @return void
     */
    public function handle(CreateCsv $event)
    {

        \Log::info('Start');
        $customers = $event->customers;
        $lang = $event->lang;

        \App\Apricot\Helpers\CreateCsvAllCustomers::storeAllCustomerToCsv($customers,$lang);

        return false;

    }
}
