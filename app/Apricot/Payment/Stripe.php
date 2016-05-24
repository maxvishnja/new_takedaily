<?php namespace App\Apricot\Payment;


use App\Apricot\Interfaces\PaymentInterface;

class Stripe implements PaymentInterface
{
	function __construct() {
		\Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET_KEY', ''));
	}

	public function charge($amount, $description, $data)
	{
		// TODO: Implement charge() method.
		// \Request::get('stripeToken')
	}

	public function createCustomer($name, $email)
	{
		// TODO: Implement createCustomer() method.
	}

	public function makeFirstPayment($amount, $customer)
	{
		// TODO: Implement makeFirstPayment() method.
	}

	public function makeRebill($amount, $customer)
	{
		// TODO: Implement makeRebill() method.
	}
	
}