<?php

namespace App\Console\Commands;

use App\Apricot\Repositories\CustomerRepository;
use App\Customer;
use App\MailStat;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;

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
		if(\Date::now(config('app.timezone')) > \Date::parse(date("Y-m-d 14:01:00"))) {

			$repo = new CustomerRepository();

			$customers = $repo->rebillAble();

			foreach ($customers->get() as $customer) {
				\App::setLocale($customer->getLocale());
				$mailEmail = $customer->getEmail();
				$mailName = $customer->getName();

				if ($customer->getLocale() == 'nl') {

					$fromEmail = 'info@takedaily.nl';

				} else {

					$fromEmail = 'info@takedaily.dk';
				}

				/* @var $customer Customer */
				if (!$customer->rebill()) {
					$customer->getPlan()->moveRebill(1); // consider a max attempts limit

                    $mailCount = new MailStat();

                    $mailCount->setMail(3);

					\Mail::send('emails.subscription-failed', ['locale' => $customer->getLocale(), 'name' => $customer->getFirstname()], function (Message $message) use ($mailEmail, $mailName, $fromEmail) {
						$message->from($fromEmail, 'TakeDaily');
						$message->to($mailEmail, $mailName);
						$message->subject(trans('checkout.mail.subject-subscription-failed'));
					});

					continue;
				}

			}
		}
	}
}
