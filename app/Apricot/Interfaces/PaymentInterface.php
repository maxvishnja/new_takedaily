<?php namespace App\Apricot\Interfaces;

interface PaymentInterface
{
	/**
	 * @param integer $amount
	 * @param string $description
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function charge($amount, $description, $data);

	/**
	 * @param string $name
	 * @param string $email
	 *
	 * @return mixed
	 */
	public function createCustomer($name, $email);

	/**
	 * @param integer $amount
	 * @param $customer
	 *
	 * @return mixed
	 */
	public function makeFirstPayment($amount, $customer);

	/**
	 * @param integer $amount
	 * @param $customer
	 *
	 * @return mixed
	 */
	public function makeRebill($amount, $customer);

	/**
	 * @param $chargeId
	 *
	 * @return bool
	 */
	public function validateCharge($chargeId);
}