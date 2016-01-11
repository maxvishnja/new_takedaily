<?php namespace App\Apricot\Libraries;


class MoneyLibrary
{
	public static function toMoneyFormat($amount = 100, $separate = false, $digits = 2)
	{
		$amount = $amount / 100;

		if( $separate )
		{
			$amount = number_format($amount, $digits, ',', '.');
		}

		return $amount;
	}

	public static function toCents($amount = 1)
	{
		return $amount * 100;
	}
}