<?php namespace App\Apricot\Libraries;

use App\Customer;
use Stripe\Charge;
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
				'amount' => $amount,
				'currency' => 'dkk',
				'customer' => $token ?: $customer->getStripeToken(),
				'description' => $description
			]);

			return dd([
				'amount'               => $amount ? : $customer->getSubscriptionPrice() * 100,
				'currency'             => 'dkk',
				'source'               => $token ? : $customer->getStripeToken(),
				'description'          => 'Betaling for ordre #' . str_pad(1, 11, 0, STR_PAD_LEFT),
				'statement_descriptor' => substr('Takedaily #' . str_pad(1, 11, 0, STR_PAD_LEFT), 0, 22),
				// todo: get order id
				'shipping'             => [
					'address'         => [
						'city'        => $customer->getCustomerAttribute('address_city'),
						'country'     => $customer->getCustomerAttribute('address_country'),
						'line1'       => $customer->getCustomerAttribute('address_line1'),
						'line2'       => $customer->getCustomerAttribute('address_line2'),
						'postal_code' => $customer->getCustomerAttribute('address_postal'),
						'state'       => $customer->getCustomerAttribute('address_state')
					],
					'name'            => $customer->getName(),
					'phone'           => $customer->getCustomerAttribute('phone'),
					'carrier'         => '', // todo: add carrier to order
					'tracking_number' => '' // todo: add tracking number to order
				]
			]);

		} catch( Card $e )
		{
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];

			print('Status is:' . $e->getHttpStatus() . "\n");
			print('Type is:' . $err['type'] . "\n");
			print('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			print('Param is:' . $err['param'] . "\n");
			print('Message is:' . $err['message'] . "\n");
		} catch( RateLimit $e )
		{
			dd($e);
			// Too many requests made to the API too quickly
		} catch( InvalidRequest $e )
		{
			dd($e);
			// Invalid parameters were supplied to Stripe's API
		} catch( Authentication $e )
		{
			dd($e);
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
		} catch( ApiConnection $e )
		{
			dd($e);
			// Network communication with Stripe failed
		} catch( Base $e )
		{
			dd($e);
			// Display a very generic error to the user, and maybe send
			// yourself an email
		} catch( Exception $e )
		{
			dd($e);
			// Something else happened, completely unrelated to Stripe
		}
	}
	
}