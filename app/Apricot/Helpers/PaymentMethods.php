<?php namespace App\Apricot\Helpers;


class PaymentMethods
{
	const GLOBAL_METHODS = [
	    'stripe'
	];

	const LOCALE_METHODS = [
		'da' => [],
	    'nl' => [ 'mollie' ],
	    'en' => []
	];

	static function getAcceptedMethodsForCountry($locale)
	{
		$methods = self::GLOBAL_METHODS;
		$localeMethods = self::LOCALE_METHODS;

		if(isset($localeMethods[$locale]))
		{
			foreach($localeMethods[$locale] as $method)
			{
				$methods[] = $method;
			}
		}

		return $methods;
	}
}