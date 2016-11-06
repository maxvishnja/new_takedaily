<?php

namespace App\Http\Controllers;

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
			\Session::forget( 'user_data' );
			\Session::forget( 'flow-completion-token' );
			\Session::put( 'package', $package->id );
			\Session::put( 'product_name', 'package' );
			\Session::put( 'vitamins', [ "1{$package->group_one}", "2{$package->group_two}", "3{$package->group_three}" ] );

			return \Redirect::action( 'CheckoutController@getCheckout' );
		}

		return view( 'package-picker-select', compact( 'package' ) );
	}

	public function post( Request $request )
	{
		$this->validate( $request, [
			'package_id' => 'required|exists:packages,id',
		    'user_data' => 'required'
		] );

		/**
		 * @var Package $package
		 */
		$package = Package::find( $request->get('package_id') );

		// todo update customer package if already logged in
		if ( \Auth::check() && \Auth::user()->isUser() )
		{
			\Auth::user()
			     ->getCustomer()
			     ->setVitamins( $vitamins );

			return \Redirect::action( 'AccountController@getHome' )
			                ->with( 'success', 'Din pakke blev opdateret!' ); // todo translate
		}

		\Session::forget( 'flow-completion-token' );
		\Session::put( 'user_data', $request->get('user_data') );
		\Session::put( 'package', $package->id );
		\Session::put( 'product_name', 'package' );

		return \Redirect::action( 'CheckoutController@getCheckout' );
	}
}
