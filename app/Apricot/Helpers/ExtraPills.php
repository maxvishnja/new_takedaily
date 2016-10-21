<?php namespace App\Apricot\Helpers;

class ExtraPills
{
	const FREE_AMOUNT = 4;

	public static function getPriceFor( $pills )
	{
		$price = 0;

		for ( $i = 0; $i < ( count( $pills ) - self::FREE_AMOUNT ); $i ++ )
		{
			$price += \App\Setting::getWithDefault( 'vitamin_price', 0 );
		}

		return $price;
	}

	public static function getTotalsFor( $pills )
	{
		$totals = [];

		for ( $i = 0; $i < ( count( $pills ) - self::FREE_AMOUNT ); $i ++ )
		{
			$totals[] = [
				'name'  => trans( 'products.oil' ),
				'price' => \App\Setting::getWithDefault( 'vitamin_price', 0 )
			];
		}

		return $totals;
	}
}