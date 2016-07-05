<?php namespace App\Apricot\Libraries;

use App\Currency as Currency;

class MoneyLibrary
{
	public static function toMoneyFormat($amount = 100, $separate = false, $digits = 2, $decpoint = ',', $thousand = '.')
	{
		$amount = $amount / 100;

		if( $separate )
		{
			$amount = number_format($amount, $digits, $decpoint, $thousand);
		}

		return $amount;
	}

	public static function toCents($amount = 1)
	{
		return $amount * 100;
	}

	/**
	 * @param \App\Currency $baseCurrency
	 * @param \App\Currency $toCurrency
	 * @param int           $amount
	 *
	 * @return float
	 */
	public static function convertCurrencies(Currency $baseCurrency, Currency $toCurrency, $amount = 100)
	{
		return $toCurrency->rate / $baseCurrency->rate * $amount;
	}

	/**
	 * @param string $baseCurrency
	 * @param string $toCurrency
	 * @param int    $amount
	 *
	 * @return float
	 */
	public static function convertCurrenciesByString($baseCurrency = 'DKK', $toCurrency = 'EUR', $amount = 100)
	{
		$base = Currency::latest()->whereName($baseCurrency)->remember(180)->first();
		$to = Currency::latest()->whereName($toCurrency)->remember(180)->first();

		if( ! $base || ! $to )
		{
			return 0; // todo fix
		}

		return self::convertCurrencies($base, $to, $amount);
	}

	/**
	 * @param string $currency
	 *
	 * @return int
	 */
	public static function getLatestRateForCurrency($currency = 'DKK')
	{
		$currency = Currency::latest()->whereName($currency)->remember(180)->first();

		if( ! $currency )
		{
			return 0; // todo fix
		}

		return $currency->rate;
	}

	/**
	 * @param float $rate
	 *
	 * @return integer
	 */
	public static function toCurrencyRate($rate = 1.0000)
	{
		return round($rate * 10000);
	}

	/**
	 * @param int $rate
	 * @param int $decimals
	 *
	 * @return string
	 */
	public static function fromCurrencyRate($rate = 10000, $decimals = 4)
	{
		return number_format($rate / 10000, $decimals);
	}
}