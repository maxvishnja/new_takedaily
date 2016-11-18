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

		dd(self::getModel());

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

	private static function getModel()
	{
		return self::CART_MODEL::findByToken(\Cookie::get(self::COOKIE_NAME));
	}

	private static function exists()
	{
		if( \Session::has('the_cart_exists'))
		{
			return true;
		}

		$exists = \Cookie::has(self::COOKIE_NAME) && self::getModel();

		if( $exists )
		{
			\Session::flash('the_cart_exists', true);
		}

		return $exists;
	}

	private static function init()
	{
		\Cookie::make(self::COOKIE_NAME, str_random(self::TOKEN_LENGTH));

		// todo add DB entry

		return true;
	}
}