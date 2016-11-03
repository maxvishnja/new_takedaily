<?php namespace App\Apricot\Helpers;


class Money
{
	private $amount;

	function __construct($amount)
	{
		$this->amount = $amount;
	}

	public function toCurrency($to)
	{
		return \App\Apricot\Libraries\MoneyLibrary::convertCurrenciesByString(config('app.base_currency'), $to, $this->amount);
	}

	function __toString()
	{
		return $this->amount;
	}
}