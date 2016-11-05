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
		$package = Package::find($id);

		if( ! $package)
		{
			return redirect()->back()->withErrors('Package not found.'); // todo translate
		}

		if( $package->isDirect() )
		{
			// todo redirect
		}

		return view('package-picker-select', compact('package'));
	}

	public function post( Request $request )
	{
		$this->validate( $request, [
			'vitamins' => 'min:3|max:5|exists:vitamins,id'
		], [
			'vitamins.min'    => 'Du har ikke valgt nok vitaminer, du skal mindst vælge :min forskellige.', // todo translate
			'vitamins.max'    => 'Du har valgt for mange vitaminer, du kan maksimalt vælge :max forskellige.', // todo translate
			'vitamins.exists' => 'Du har valgt et vitamin som ikke findes, hvordan ved vi ikke, prøv igen.', // todo translate
		] );

		$vitamins = collect( $request->get( 'vitamins' ) );

		if ( \Auth::check() && \Auth::user()->isUser() )
		{
			\Auth::user()
			     ->getCustomer()
			     ->setVitamins( $vitamins );

			return \Redirect::action( 'AccountController@getHome' )
			                ->with( 'success', 'Dine vitaminer blev opdateret!' ); // todo translate
		}

		\Session::forget( 'user_data' );
		\Session::forget( 'flow-completion-token' );
		\Session::put( 'package', '' );
		\Session::put( 'product_name', 'package' );

		return \Redirect::action( 'CheckoutController@getCheckout' );
	}
}
