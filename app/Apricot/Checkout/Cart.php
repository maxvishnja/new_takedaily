<?php namespace App\Apricot\Checkout;

class Cart
{
	const COOKIE_NAME = 'takedaily_cart_token';
	const TOKEN_PREFIX = 'cart_';
	const TOKEN_LENGTH = 27; // TOKEN_PREFIX is not counted here. This is for the random token part
	const CART_MODEL = \App\Cart::class;

	public static function get()
	{
		if( !self::exists())
		{
			return collect([]);
		}


		return collect([]);
		// todo get cart
	}

	public static function clear()
	{
		\Cookie::forget(self::COOKIE_NAME);

		return true;
	}

	public static function addTo()
	{
		if( !self::exists())
		{
			self::init();
		}

		// todo add
	}

	private static function exists()
	{
		return \Cookie::has(self::COOKIE_NAME); // todo check DB too
	}

	private static function init()
	{
		\Cookie::make(self::COOKIE_NAME, str_random(self::TOKEN_LENGTH));

		// todo add DB entry

		return true;
	}
}