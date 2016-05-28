<?php namespace App\Apricot\Payment;

use App\Apricot\Interfaces\PaymentInterface;
use App\Apricot\Libraries\MoneyLibrary;

class Mollie implements PaymentInterface
{
	/**
	 * @param int    $amount
	 * @param string $description
	 * @param array  $data
	 *
	 * @return \Mollie_API_Object_Payment
	 */
	public function charge($amount, $description, $data = [ ])
	{
		$charge = [
			"amount"      => MoneyLibrary::toMoneyFormat($amount, true, 2, '.', ''),
			"description" => $description,
			"redirectUrl" => \URL::to('checkout/verify/mollie'),
		];

		$charge = array_merge($charge, $data);

		return \Mollie::api()->payments()->create($charge);
	}

	/**
	 * @param string $name
	 * @param string $email
	 *
	 * @return \Mollie_API_Object_Customer
	 */
	public function createCustomer($name, $email)
	{
		return \Mollie::api()->customers()->create([
			"name"  => $name,
			"email" => $email,
		]);
	}

	/**
	 * @param int                         $amount
	 * @param \Mollie_API_Object_Customer $customer
	 *
	 * @return \Mollie_API_Object_Payment
	 */
	public function makeFirstPayment($amount, $customer)
	{
		return $this->charge($amount, 'Initial', [
			'customerId'    => $customer->id,
			'recurringType' => 'first'
		]);
	}

	/**
	 * @param int                         $amount
	 * @param \Mollie_API_Object_Customer $customer
	 *
	 * @return bool|\Mollie_API_Object_Payment
	 */
	public function makeRebill($amount, $customer)
	{
		$mandates = \Mollie::api()->customersMandates()->withParentId($customer->id)->all();

		$hasValidMandate = false;

		foreach($mandates as $mandate)
		{
			if( $mandate->status == 'valid' )
			{
				$hasValidMandate = true;
			}
		}

		if( ! $hasValidMandate )
		{
			return false;
		}

		return $this->charge($amount, 'Rebill', [
			'customerId'    => $customer->id,
			'recurringType' => 'recurring'
		]);
	}

	/**
	 * @param $chargeId
	 *
	 * @return bool
	 */
	public function validateCharge($chargeId)
	{
		/** @var \Mollie_API_Object_Payment $payment */
		$payment = \Mollie::api()->payments()->get($chargeId);

		return $payment->isPaid();
	}

	/**
	 * @param $orderId
	 *
	 * @return \Mollie_API_Object_Payment
	 */
	public function findOrder($orderId)
	{
		return \Mollie::api()->payments()->get($chargeId);
	}

	/**
	 * @param $customerId
	 *
	 * @return \Mollie_API_Object_Customer
	 */
	public function findCustomer($customerId)
	{
		return \Mollie::api()->customers()->get($customerId);
	}

}