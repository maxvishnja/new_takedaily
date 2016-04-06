<?php

namespace App\Console\Commands;

use App\Apricot\Repositories\CustomerRepository;
use App\Customer;
use Illuminate\Console\Command;

class SubscriptionRebillCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:rebill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charges customers cards';

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
		$repo = new CustomerRepository();

		$customers = $repo->rebillAble();

		foreach($customers->get() as $customer)
		{
			/* @var $customer Customer */
			if( !$customer->rebill() )
			{
				$customer->getPlan()->moveRebill(1);

				return false;
			}

			$mailEmail = $customer->getEmail();
			$mailName  = $customer->getName();

			\Mail::queue('emails.subscription', [], function ($message) use ($mailEmail, $mailName)
			{
				$message->to($mailEmail, $mailName);
				$message->from('noreply@takedaily.dk', 'Take Daily');
				$message->subject(trans('checkout.mail.subject-subscription'));
			});
		}
    }
}
