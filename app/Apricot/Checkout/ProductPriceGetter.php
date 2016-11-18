<?php namespace App\Apricot\Checkout;


use App\Setting;

class ProductPriceGetter
{
	public static function getPrice($product)
	{
		$locale = \App::getLocale();

		return Setting::getWithDefault("{$locale}_{$product}_price", null);
	}
}