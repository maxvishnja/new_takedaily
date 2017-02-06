<?php

namespace App\Console\Commands;

use App\Customer;
use App\Plan;
use Illuminate\Console\Command;

class NotifyPendingRebills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send e-mails with pending rebills';

    /**
     * Create a new command instance.
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


        $plans = Plan::rebillPending()->notNotifiedPending()->get();
       $customers = Plan::where('subscription_cancelled_at','=',NULL)->get();
	    /** @var Plan $plan */
//	    foreach($plans as $plan)
//	    {
//	    	$plan->notifyUserPendingRebill();
//	    }
        foreach($customers as $customer){
           $ds= $customer->subscription_rebill_at;
            $customer->subscription_rebill_at =  \Date::createFromFormat( 'Y-m-d H:i:s', $ds  )->addDays(-7);
            echo $customer->subscription_rebill_at."-----";
            $customer->update();
        }
dd('11');
	    echo "Notified {$plans->count()} user(s).\n";
	    return true;
    }
}
