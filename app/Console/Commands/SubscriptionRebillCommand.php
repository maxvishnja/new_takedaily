<?php

namespace App\Console\Commands;

use App\Apricot\Libraries\MoneyLibrary;
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
			$customer->rebill();

			$data = [
				'description'   => 'subscription',
				'priceTotal'    => MoneyLibrary::toCents($customer->getPlan()->getTotal()),
				'priceSubtotal' => MoneyLibrary::toCents($customer->getPlan()->getTotal() * 0.8),
				'priceTaxes'    => MoneyLibrary::toCents($customer->getPlan()->getTotal() * 0.2)
			];

			$mailEmail = $customer->getEmail();
			$mailName  = $customer->getName();

			\Mail::queue('emails.order', $data, function ($message) use ($mailEmail, $mailName)
			{
				$message->to($mailEmail, $mailName);
				$message->from('noreply@takedaily.dk', 'Take Daily');
				$message->subject(trans('checkout.mail.subject'));
			});
		}
    }
}
