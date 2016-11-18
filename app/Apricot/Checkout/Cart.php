<?php namespace App\Apricot\Checkout;

use Illuminate\Support\Collection;

class Cart
{
	// todo handle coupons, maybe - and giftcards
	const COOKIE_NAME  = 'takedaily_cart_token';
	const SESSION_NAME = 'the_cart_exists';
	const TOKEN_PREFIX = 'cart_';
	const TOKEN_LENGTH = 27; // TOKEN_PREFIX is not counted here. This is for the random token part
	const CART_MODEL   = \App\Cart::class;

	public static function get()
	{
		if ( ! self::exists() )
		{
			return collect( [] );
		}

		return collect( self::getModel()->getLines() );
	}

	public static function getInfo()
	{
		if ( ! self::exists() )
		{
			return collect( [] );
		}

		return collect( self::getModel()->getInfo() );
	}

	public static function clear()
	{
		\Session::forget( self::COOKIE_NAME );
		\Session::forget( self::SESSION_NAME );

		return true;
	}

	public static function deductProduct( $productName, $price = null )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		if ( is_null($price) )
		{
			$price = ProductPriceGetter::getPrice( $productName );
		}

		$price *= - 1;

		$cart = self::get();

		$cart->push( [ 'name' => $productName, 'amount' => (int) $price ] );

		self::set( $cart );
	}

	public static function getTotal()
	{
		$lines = self::get();

		return $lines->sum( 'amount' );
	}

	public static function addProduct( $productName, $price = null )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		if ( is_null($price) )
		{
			$price = ProductPriceGetter::getPrice( $productName );
		}

		$cart = self::get();

		$cart->push( [ 'name' => $productName, 'amount' => (int) $price ] );

		self::set( $cart );
	}

	public static function addInfo( $key, $value )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		$info = self::getInfo();

		$info->put( $key, $value );

		self::setInfo( $info );
	}

	private static function set( Collection $cart )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		self::getModel()->update( [ 'lines' => json_encode( $cart->toArray() ) ] );
	}

	private static function setInfo( Collection $info )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		self::getModel()->update( [ 'extra_data' => json_encode( $info->toArray() ) ] );
	}

	/**
	 * @return null|\App\Cart
	 */
	private static function getModel()
	{
		return ( self::CART_MODEL )::findByToken( \Session::get( self::COOKIE_NAME ) );
	}

	private static function exists()
	{
		if ( \Session::has( self::SESSION_NAME ) )
		{
			return true;
		}

		$exists = \Session::has( self::COOKIE_NAME ) && self::getModel();

		if ( $exists )
		{
			\Session::flash( self::SESSION_NAME, true );
		}

		return $exists;
	}

	private static function init()
	{
		$token = str_random( self::TOKEN_LENGTH );

		\Session::set( self::COOKIE_NAME, $token );

		( self::CART_MODEL )::create( [
			'token'      => $token
		] );

		return true;
	}
}