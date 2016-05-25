<?php namespace App\Apricot\Payment;


use App\Apricot\Interfaces\PaymentInterface;
use Stripe\Charge;
use Stripe\Customer;

class Stripe implements PaymentInterface
{
	function __construct()
	{
		\Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET_KEY', ''));
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
		} catch( Card $ex )
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
			'customer'     => $customer->id,
			'currency'   => 'DKK' // todo: un-hardcode this
		]);
	}

	public function makeRebill($amount, $customer)
	{
		// TODO: Implement makeRebill() method.
	}

	/**
	 * @param $chargeId
	 *
	 * @return bool
	 */
	public function validateCharge($chargeId)
	{
		/** @var Charge $payment */
		$payment = Charge::retrieve($chargeId);

		return $payment->status == 'succeeded';
	}
	
}