<?php

namespace App\Listeners;
use App\Events\CreateAllCsv;
use App\Setting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateCsvAllCustomers //implements ShouldQueue
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
     * @param  CreateAllCsv  $event
     * @return void
     */
    public function handle(CreateAllCsv $event)
    {

        \Log::info('Enter to listener '.$event->lang);

        try {

            $stat_count = Setting::where('identifier','=','stat_'.$event->lang)->first();

            if ($stat_count->value == 1){

                \Log::info('Start all '.$event->lang);

                $customers = $event->customers;

                $lang = $event->lang;

                \App\Apricot\Helpers\CreateCsvAllCustomers::storeAllCustomerToCsv($customers,$lang);
            }


        } catch (\Exception $exception) {

            \Log::error($exception->getFile() . " on line " . $exception->getLine());

            \Log::error($exception->getTraceAsString());

        }

    }

}