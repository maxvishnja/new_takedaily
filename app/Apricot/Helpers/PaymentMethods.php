<?php namespace App\Apricot\Helpers;


class PaymentMethods
{
	const GLOBAL_METHODS = [
		'stripe'
	];

	const LOCALE_METHODS = [
		'da' => [ 'stripe_dk' ],
		'nl' => [ 'mollie' ],
		'en' => []
	];

	const ICONS = [
		'stripe'    => [ 'mastercard', 'visa' ],
		'mollie'    => [ 'ideal' ],
		'stripe_dk' => [ 'dk' ]
	];

	public static function getAcceptedMethodsForCountry( $locale )
	{
		$methods       = self::GLOBAL_METHODS;
		$localeMethods = self::LOCALE_METHODS;

		if ( isset( $localeMethods[ $locale ] ) )
		{
			foreach ( $localeMethods[ $locale ] as $method )
			{
				$methods[] = $method;
			}
		}

		return $methods;
	}

	public static function getIconsForMethods( $methods )
	{
		$icons = [];

		foreach ( $methods as $method )
		{
			$constIcons = self::ICONS;
			if ( isset( $constIcons[ $method ] ) )
			{
				foreach ( $constIcons[ $method ] as $constIcon )
				{
					$icons[] = $constIcon;
				}
			}
		}

		return $icons;
	}
}