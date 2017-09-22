<?php namespace App\Apricot\Checkout;

use Illuminate\Support\Collection;

class Cart
{
	const COOKIE_NAME  = 'takedaily_cart_token';
	const SESSION_NAME = 'the_cart_exists';
	const TOKEN_PREFIX = 'cart_';
	const TOKEN_LENGTH = 27; // TOKEN_PREFIX is not counted here. This is for the random token part
	const CART_MODEL   = \App\Cart::class;

	public static function get( $showAll = true )
	{
		if ( ! self::exists() )
		{
			return collect( [] );
		}

		$lines = collect( self::getModel()->getLines() );

		if ( ! $showAll )
		{
			$lines = $lines->filter( function ( $item )
			{
				return $item->amount <> 0;
			} );
		}

		return $lines;
	}

	public static function getInfo()
	{
		if ( ! self::exists() )
		{
			return collect( [] );
		}

		return collect( self::getModel()->getInfo() );
	}

	public static function getInfoItem($key, $fallback = null)
	{
		if ( ! self::exists() )
		{
			return collect( [] );
		}

		return collect( self::getModel()->getInfo() )->get($key, $fallback);
	}

	public static function empty()
	{
		self::setInfo(collect([]));
		self::set(collect([]));

		return true;
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

		if ( is_null( $price ) )
		{
			$price = ProductPriceGetter::getPrice( $productName );
		}

		$price *= - 1;

		$cart = self::get();

		$cart->push( [ 'name' => $productName, 'amount' => (int) $price, 'key' => 'discount' ] );

		self::set( $cart );
	}

	public static function getTotal()
	{
		$lines = self::get();

		return $lines->sum( 'amount' );
	}

	public static function addProduct( $productName, $price = null, $extraData = [] )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		if ( is_null( $price ) )
		{
			$price = ProductPriceGetter::getPrice( $productName );
		}

		$cart = self::get();

		$data = collect( [ 'name' => $productName, 'amount' => (int) $price ] );

		foreach ( $extraData as $key => $item )
		{
			$data->put( $key, $item );
		}

		$data = $data->toArray();

		$cart->push( $data );

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

	public static function hasInfo( $key )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		$info = self::getInfo();

		return $info->has( $key );
	}

	public static function removeInfo( $key )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		$info = self::getInfo();

		$info->forget( $key );

		self::setInfo( $info );
	}

	public static function removeProduct( $key )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		$cart = self::get();

		$cart = $cart->reject( function ( $item ) use ( $key )
		{
			if ( ! isset( $item->key ) )
			{
				return false;
			}

			return $item->key == $key;
		} )->flatten();

		self::set( $cart );
	}

	private static function set( Collection $cart )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		self::getModel()->update( [ 'lines' => $cart->toJson() ] );
	}

	private static function setInfo( Collection $info )
	{
		if ( ! self::exists() )
		{
			self::init();
		}

		self::getModel()->update( [ 'extra_data' => $info->toJson() ] );
	}

	/**
	 * @return null|\App\Cart
	 */
	private static function getModel()
	{
		return ( self::CART_MODEL )::findByToken( \Session::get( self::COOKIE_NAME ) );
	}

	public static function exists()
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
			'token' => $token
		] );

		return true;
	}
}