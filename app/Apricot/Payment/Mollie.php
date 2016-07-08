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
		$amount = round(MoneyLibrary::convertCurrenciesByString(config('currency', config('app.base_currency')), 'EUR', $amount)); // todo test

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

		/** @var \Mollie_API_Object_Customer_Mandate $mandate */
		foreach($mandates as $mandate)
		{
			if( $mandate->isValid() )
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
		$payment = $this->findOrder($chargeId);

		return $payment->isPaid();
	}

	/**
	 * @param $orderId
	 *
	 * @return \Mollie_API_Object_Payment
	 */
	public function findOrder($orderId)
	{
		return \Mollie::api()->payments()->get($orderId);
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

	public function addMethod($source, $customer)
	{ // todo.. find a way to disable this for Mollie, as it seems to be impossible.
		return \Mollie::api()->customersMandates()->withParentId($customer->id)->create([

		]);
	}

}