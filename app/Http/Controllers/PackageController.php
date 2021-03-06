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
			return redirect()->back()->withErrors( trans('pick-package.errors.not-found') );
		}

		if ( $package->isDirect() )
		{
			Cart::clear();
			Cart::addProduct( 'subscription' );

			if ( \Auth::check() && \Auth::user()->isUser() )
			{
				\Auth::user()->getCustomer()->unsetAllUserdata();
				\Auth::user()
				     ->getCustomer()
				     ->updateCustomUserData( json_decode( json_encode( [
					     'custom' => [
						     'one'   => $package->group_one,
						     'two'   => $package->group_two,
						     'three' => $package->group_three
					     ]
				     ] ) ) );

				\Auth::user()->getCustomer()->getPlan()->update(['price' => Cart::getTotal()]);

				return \Redirect::action( 'AccountController@getSettingsSubscription' )
				                ->with( 'success', trans('pick-package.updated') );
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

			foreach ( $vitamins as $i => $vitamin )
			{
				Cart::addProduct( \App\Apricot\Libraries\PillLibrary::$codes[ $vitamin ], '' );
				Cart::addInfo( "vitamins.{$i}", $vitamin );
			}
			Cart::addProduct( 'shipping', 0 );

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

		Cart::clear();
		Cart::addProduct( 'subscription' );
		Cart::addProduct( 'shipping', 0 );

		if ( \Auth::check() && \Auth::user()->isUser() )
		{
			\Auth::user()->getCustomer()->unsetAllUserdata();
			\Auth::user()
			     ->getCustomer()
			     ->updateCustomUserData( $combinedUserData );

			\Auth::user()->getCustomer()->getPlan()->update(['price' => Cart::getTotal()]);

			return \Redirect::action( 'AccountController@getSettingsSubscription' )
			                ->with( 'success', trans('pick-package.updated') );
		}

		\Session::forget( 'flow-completion-token' );
		\Session::put( 'user_data', json_decode( $request->get( 'user_data' ) ) );
		\Session::put( 'package', $package->id );
		\Session::put( 'product_name', 'package' );

		$lib = new \App\Apricot\Libraries\CombinationLibraryNew();
		$lib->generateResult( $combinedUserData );

		$i = 0;
		foreach ( $lib->getResult() as $vitaminCode )
		{
			$i ++;
			Cart::addProduct( \App\Apricot\Libraries\PillLibrary::$codes[ $vitaminCode ], '' );
			Cart::addInfo( "vitamins.{$i}", $vitaminCode );
		}

		Cart::addInfo( "user_data", $combinedUserData );

		return \Redirect::action( 'CheckoutController@getCheckout' );
	}
}
