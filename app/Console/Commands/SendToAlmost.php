<?php

namespace App\Console\Commands;

use App\AlmostCustomers;
use App\Apricot\Repositories\CustomerRepository;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;

class SendToAlmost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'almost:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to almost customers';

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

        $almosts = $repo->getAlmostCustomerNotSend();

        foreach($almosts as $almost){

            \App::setLocale($almost->location);

            $mailEmail = $almost->email;
            $mailName = 'TakeDaily';

            if ($almost->location == 'nl') {

                $fromEmail = 'info@takedaily.nl';

            } else {

                $fromEmail = 'info@takedaily.dk';
            }

            $almost->sent = 1;

            $newalmost = AlmostCustomers::find($almost->id);
            $newalmost->sent = 1;
            $newalmost->save();

            \Mail::send('emails.almost-customers', ['locale' => $almost->location], function (Message $message) use ($mailEmail, $mailName, $fromEmail) {
                $message->from($fromEmail, 'TakeDaily');
                $message->to($mailEmail, $mailName);
                $message->subject(trans('mails.almost-subject'));
            });

            continue;
        }

        return 'Success';
    }


}
