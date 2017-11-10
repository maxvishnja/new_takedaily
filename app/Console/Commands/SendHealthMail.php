<?php

namespace App\Console\Commands;

use App\Customer;
use App\Apricot\Repositories\CustomerRepository;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;

class SendHealthMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'healthmail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail with a question about his health';

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

        $repo = new CustomerRepository();

        $customers = $repo->getNewCustomer();

            foreach ( $customers as $customer ) {

             if($customer){

                \App::setLocale($customer->customer->getLocale());

                $mailEmail = $customer->customer->getEmail();
                $mailName  = $customer->customer->getName();
                if($customer->customer->getLocale()== 'nl') {
                    $fromEmail = 'info@takedaily.nl';
                } else{
                    $fromEmail = 'info@takedaily.dk';
                }

                \Log::info('Health mail send to Customer ID '.$customer->customer->id." email ".$mailEmail);

                \Mail::send( 'emails.control-health', [ 'locale' => $customer->customer->getLocale(), 'name' => $customer->customer->getFirstname(), 'id' =>$customer->customer->id ], function ( Message $message ) use ( $mailEmail, $mailName, $fromEmail )
                {
                    $message->from( $fromEmail, 'TakeDaily' );
                    $message->to( $mailEmail, $mailName );
                    $message->subject( trans( 'mails.control-health.title' ) );
                } );
                continue;

                }
            }
        }


}
