<?php

namespace App\Listeners;

use App\Events\CreateCsv;
use App\Setting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateCsvCustomers
{

    //use InteractsWithQueue;

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
     * @param  CreateCsv $event
     * @return void
     */
    public function handle(CreateCsv $event)
    {
        \Log::info('Enter to month listener '.$event->lang);

        try {
            $stat_count = Setting::where('identifier', '=', 'month_stat_' . $event->lang)->first();

            if ($stat_count->value == 1) {

                \Log::info('Start month ' . $event->lang);

                $customers = $event->customers;

                $lang = $event->lang;

                $offset = $event->offset;

                \App\Apricot\Helpers\CreateCsvMonths::storeAllCustomerToCsv($offset, $customers, $lang);
            }


        } catch (\Exception $exception) {

            \Log::error($exception->getFile() . " on line " . $exception->getLine());

            \Log::error($exception->getTraceAsString());

        }


    }
}