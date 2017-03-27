<?php

namespace App\Console\Commands;

use App\Apricot\Repositories\CustomerRepository;
use App\Order;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;

class CheckGoalAmbassador extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:ambassador';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check target to goal of ambassador';

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

        $ambassadors = $repo->getAmbassador();

        foreach($ambassadors as $customer){

            $goals = Order::where('coupon','=',$customer->coupon)->count();

            if($goals != $customer->prev_goal){

                if($goals % $customer->goal == 0){

                    $customer->setPrevGoal($goals);

                    \App::setLocale($customer->getLocale());

                    $mailEmail = 'maxadm8@gmail.com';


                    if ($customer->getLocale() == 'nl') {

                        $fromEmail = 'info@takedaily.nl';

                    } else {

                        $fromEmail = 'info@takedaily.dk';
                    }

                    \Mail::queue('emails.ambassador', ['locale' => $customer->getLocale(), 'name' => $customer->getName(),'count' => $goals], function (Message $message) use ($mailEmail, $fromEmail) {

                        $message->from($fromEmail, 'TakeDaily');
                        $message->to($mailEmail, 'Takedaily admin');
                        $message->subject(trans('mails.ambassador.subject'));
                    });

                    continue;


                }

            }

        }


    }
}
