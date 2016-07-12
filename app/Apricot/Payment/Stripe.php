<?php namespace App\Apricot\Payment;


use App\Apricot\Interfaces\PaymentInterface;
use Stripe\Card;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\Base;
use Stripe\Error\InvalidRequest;
use Stripe\Error\RateLimit;

class Stripe implements PaymentInterface
{
	function __construct()
	{
		\Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET_KEY', ''));
	}

	public function findOrder($orderId)
	{
		return Charge::retrieve($orderId);
	}

	public function findCustomer($customerId)
	{
		return Customer::retrieve($customerId);
	}

	public function charge($amount, $description, $data)
	{
		$charge = [
			"amount"      => $amount,
			"description" => $description,
		];

		$charge = array_merge($charge, $data);

		return Charge::create($charge); // todo catch errors
	}

	public function createCustomer($name, $email)
	{
		try
		{
			return Customer::create([
				'description' => "Customer for {$email}",
				'email'       => $email,
				'source'      => \Request::get('stripeToken')
			]);
		} catch( \Stripe\Error\Card $ex )
		{
			return false;
		} catch( \Exception $ex )
		{
			return false;
		} catch( \Error $ex )
		{
			return false;
		}
	}

	public function makeFirstPayment($amount, $customer)
	{
		return $this->charge($amount, 'Initial', [
			'customer' => $customer->id,
			'currency' => 'EUR' // todo: un-hardcode this
		]);
	}

	public function makeRebill($amount, $customer)
	{
		try
		{
			return Charge::create([
				'amount'               => $amount,
				'currency'             => 'EUR',
				'customer'             => $customer->id,
				'description'          => 'rebill',
				'statement_descriptor' => 'TakeDaily',
			]);
		} catch( \Stripe\Error\Card $e )
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
		} catch( \Exception $e )
		{
			\Session::flash('error_message', $e->getMessage());

			return false;
			// Something else happened, completely unrelated to Stripe
		} catch( \Error $e )
		{
			\Session::flash('error_message', $e->getMessage());

			return false;
		}
	}

	/**
	 * @param $chargeId
	 *
	 * @return bool
	 */
	public function validateCharge($chargeId)
	{
		/** @var Charge $payment */
		$payment = $this->findOrder($chargeId);

		return $payment->status == 'succeeded';
	}

	/**
	 * @param $source
	 * @param Customer $customer
	 *
	 * @return Card
	 */
	public function addMethod($source, $customer)
	{
		try
		{
			return $customer->sources->create([
				'source' => $source
			]);
		} catch( \Stripe\Error\Card $ex )
		{
			\Session::flash('error_message', $ex->getMessage());

			return false;
		} catch( \Exception $ex )
		{
			\Session::flash('error_message', $ex->getMessage());

			return false;
		} catch( \Error $ex )
		{
			\Session::flash('error_message', $ex->getMessage());

			return false;
		}
	}

	public function getCustomerMethods($customerId)
	{
		// TODO: Implement getCustomerMethods() method.
	}


}