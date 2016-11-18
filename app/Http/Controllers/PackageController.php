<?php

namespace App\Http\Controllers;

use App\Apricot\Checkout\Cart;
use App\Apricot\Libraries\PillLibrary;
use App\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
	public function get()
	{
		$packages = Package::select( [ 'id', 'identifier' ] )->orderBy( 'id', 'ASC' )->get();

		return view( 'package-picker', compact( 'packages' ) );
	}

	public function select( $id )
	{
		/**
		 * @var Package $package
		 */
		$package = Package::find( $id );

		if ( ! $package )
		{
			return redirect()->back()->withErrors( 'Package not found.' ); // todo translate
		}

		if ( $package->isDirect() )
		{
			if ( \Auth::check() && \Auth::user()->isUser() )
			{
				\Auth::user()
				     ->getCustomer()
				     ->updateCustomUserData( json_decode( json_encode( [
					     'custom' => [
						     'one'   => $package->group_one,
						     'two'   => $package->group_two,
						     'three' => $package->group_three
					     ]
				     ] ) ) );

				return \Redirect::action( 'AccountController@getSettingsSubscription' )
				                ->with( 'success', 'Din pakke blev opdateret!' ); // todo translate
			}

			$vitamins = [
				PillLibrary::getPill(1, $package->group_one),
				PillLibrary::getPill(2, $package->group_two),
				PillLibrary::getPill(3, $package->group_three)
			];

			\Session::forget( 'user_data' );
			\Session::forget( 'flow-completion-token' );
			\Session::put( 'package', $package->id );
			\Session::put( 'product_name', 'package' );
			\Session::put( 'vitamins', $vitamins );

			Cart::clear();
			Cart::addProduct( 'subscription' );
			Cart::addProduct( 'shipping', 0 );

			foreach ( $vitamins as $i => $vitamin )
			{
				Cart::addProduct( \App\Apricot\Libraries\PillLibrary::$codes[ $vitamin ], '' );
				Cart::addInfo( "vitamins.{$i}", $vitamin );
			}

			return \Redirect::action( 'CheckoutController@getCheckout' );
		}

		return view( 'package-picker-select', compact( 'package' ) );
	}

	public function post( Request $request )
	{
		$this->validate( $request, [
			'package_id' => 'required|exists:packages,id',
			'user_data'  => 'required'
		] );

		/**
		 * @var Package $package
		 */
		$package = Package::find( $request->get( 'package_id' ) );

		$combinedUserData = json_decode( $request->get( 'user_data' ) );

		dd($combinedUserData);

		if ( \Auth::check() && \Auth::user()->isUser() )
		{
			\Auth::user()
			     ->getCustomer()
			     ->updateCustomUserData( $combinedUserData );

			return \Redirect::action( 'AccountController@getSettingsSubscription' )
			                ->with( 'success', 'Din pakke blev opdateret!' ); // todo translate
		}

		\Session::forget( 'flow-completion-token' );
		\Session::put( 'user_data', json_decode( $request->get( 'user_data' ) ) );
		\Session::put( 'package', $package->id );
		\Session::put( 'product_name', 'package' );

		Cart::clear();
		Cart::addProduct( 'subscription' );

		$lib = new \App\Apricot\Libraries\CombinationLibrary();
		$lib->generateResult( $combinedUserData );

		$i = 0;
		foreach ( $lib->getResult() as $combKey => $combVal )
		{
			$i ++;
			$vitamin_code = \App\Apricot\Libraries\PillLibrary::getPill( $combKey, $combVal );
			Cart::addProduct( \App\Apricot\Libraries\PillLibrary::$codes[ $vitamin_code ], '' );
			Cart::addInfo( "vitamins.{$i}", $vitamin_code );
		}

		Cart::addInfo( "user_data", $combinedUserData );

		return \Redirect::action( 'CheckoutController@getCheckout' );
	}
}
