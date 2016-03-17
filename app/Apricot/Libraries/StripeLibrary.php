<?php namespace App\Apricot\Libraries;

use App\Customer;
use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Stripe;

class StripeLibrary
{

	function __construct()
	{
		Stripe::setApiKey(env('STRIPE_API_SECRET_KEY', ''));
	}

	/**
	 * @param \App\Customer $customer
	 *
	 * @return \Stripe\Customer
	 */
	public function getCustomer(Customer $customer)
	{
		if ( is_null($customer->getPlan()->getStripeToken()) || empty($customer->getPlan()->getStripeToken()) )
		{
			return false;
		}

		return $customer = \Cache::remember('stripe_customer_for_customer_' . $customer->id, 10, function () use ($customer)
		{
			return \Stripe\Customer::retrieve($customer->getPlan()->getStripeToken());
		});
	}

	public function chargeCustomer(Customer $customer, $token = null, $amount = null, $description = 'Subscription')
	{
		try
		{
			return Charge::create([
				'amount'               => $amount ? : $customer->getSubscriptionPrice(),
				'currency'             => 'dkk',
				'customer'             => $token ? : $customer->getStripeToken(),
				'description'          => $description,
				'statement_descriptor' => substr('Takedaily #' . str_pad(1, 11, 0, STR_PAD_LEFT), 0, 22),
			]);
		} catch( Card $e )
		{
			return false;
		} catch( RateLimit $e )
		{
			return false;
			// Too many requests made to the API too quickly
		} catch( InvalidRequest $e )
		{
			return false;
			// Invalid parameters were supplied to Stripe's API
		} catch( Authentication $e )
		{
			return false;
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
		} catch( ApiConnection $e )
		{
			return false;
			// Network communication with Stripe failed
		} catch( Base $e )
		{
			return false;
			// Display a very generic error to the user, and maybe send
			// yourself an email
		} catch( Exception $e )
		{
			return false;
			// Something else happened, completely unrelated to Stripe
		} catch ( \Error $e )
		{
			return false;
		}
	}
	
}