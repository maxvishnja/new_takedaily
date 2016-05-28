<?php namespace App\Apricot\Libraries;

use App\Apricot\Interfaces\PaymentInterface;

class PaymentHandler
{
	private $provider;

	function __construct(PaymentInterface $paymentProvider)
	{
		$this->provider = $paymentProvider;
	}

	public function makeRebill($amount, $customer)
	{
		return $this->provider->makeRebill($amount, $customer);
	}

	public function createCustomer($name, $email)
	{
		return $this->provider->createCustomer($name, $email);
	}

	public function makeInitialPayment($amount, $customer)
	{
		return $this->provider->makeFirstPayment($amount, $customer);
	}

	public function isChargeValid($chargeId)
	{
		return $this->provider->validateCharge($chargeId);
	}

	public function getCustomer($customerId)
	{
		return $this->provider->findCustomer($customerId);
	}

	public function getOrder($orderId)
	{
		return $this->provider->findOrder($orderId);
	}
}