<?php namespace App\Apricot\Libraries;
// FIXME: this should not be used anywhere.
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
			\Session::flash('error_message', $e->getMessage());
			return false;
		} catch( RateLimit $e )
		{
			\Session::flash('error_message', $e->getMessage());
			return false;
			// Too many requests made to the API too quickly
		} catch( InvalidRequest $e )
		{
			\Session::flash('error_message', $e->getMessage());
			return false;
			// Invalid parameters were supplied to Stripe's API
		} catch( Authentication $e )
		{
			\Session::flash('error_message', $e->getMessage());
			return false;
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
		} catch( ApiConnection $e )
		{
			\Session::flash('error_message', $e->getMessage());
			return false;
			// Network communication with Stripe failed
		} catch( Base $e )
		{
			\Session::flash('error_message', $e->getMessage());
			return false;
			// Display a very generic error to the user, and maybe send
			// yourself an email
		} catch( Exception $e )
		{
			\Session::flash('error_message', $e->getMessage());
			return false;
			// Something else happened, completely unrelated to Stripe
		} catch ( \Error $e )
		{
			\Session::flash('error_message', $e->getMessage());
			return false;
		}
	}
	
}