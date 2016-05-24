<?php namespace App\Apricot\Libraries;


class PaymentDelegator
{
	protected static $methods = [
		'stripe' => \App\Apricot\Payment\Stripe::class,
		'mollie' => \App\Apricot\Payment\Mollie::class
	];

	public static function getMethod($name)
	{
		return new self::$methods[$name];
	}
}