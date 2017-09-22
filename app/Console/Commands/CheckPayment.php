<?php

namespace App\Console\Commands;

use App\PaymentsError;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;

class CheckPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks connect payment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        /*
         * Check Stripe connection
         */
        try {

            \App\Apricot\Payment\Stripe::checkConnection();

        } catch (\Exception $exception) {

            $error = new PaymentsError();
            $error->createError('Stripe', $exception->getMessage());

            \Log::error("Connection error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

            \Mail::queue('emails.payment-error', ['locale' => 'nl', 'payment' => 'Stripe'], function (Message $message) {

                $message->from('info@takedaily.com', 'TakeDaily');
                $message->to('info@takedaily.com,nick.maslii@albiondigitalaction.com', 'Takedaily admin');
                $message->subject('Payments Stripe error');
            });

            return false;
        }




        /*
         * Check Mollie connection
         */
        try {

            \App\Apricot\Payment\Mollie::checkConnection();

        } catch (\Exception $exception) {

            $error = new PaymentsError();
            $error->createError('Mollie', $exception->getMessage());

            \Log::error("Connection error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

            \Mail::queue('emails.payment-error', ['locale' => 'nl', 'payment' => 'Mollie'], function (Message $message) {

                $message->from('info@takedaily.com', 'TakeDaily');
                $message->to('info@takedaily.com,nick.maslii@albiondigitalaction.com', 'Takedaily admin');
                $message->subject('Payments Mollie error');
            });

            return false;
        }


    }
}
