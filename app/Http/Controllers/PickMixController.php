<?php

namespace App\Http\Controllers;

use App\Apricot\Checkout\Cart;
use App\Vitamin;
use Illuminate\Http\Request;

class PickMixController extends Controller
{
	public function get( Request $request )
	{
		$vitamins         = Vitamin::all();
		$isCustomer       = \Auth::check() && \Auth::user()->isUser();
		$selectedVitamins = [];

		if ( $isCustomer )
		{
			$selectedVitamins = json_decode( \Auth::user()
			                                      ->getCustomer()
			                                      ->getVitamins() ); // consider is this foolproof? (what if it is not json, or such)
		}
		elseif ( $request->has( 'selected' ) )
		{
			$selectedVitamins = array_flatten( Vitamin::select( 'id' )->whereIn( 'code', explode( ',', $request->get( 'selected' ) ) )->get()->toArray() );
		}

		return view( 'pick', compact( 'vitamins', 'isCustomer', 'selectedVitamins' ) );
	}

	public function post( Request $request )
	{
		$this->validate( $request, [
			'vitamins'       => 'min:3|max:5|exists:vitamins,id'
		], [
			'vitamins.min'          => 'Du har ikke valgt nok vitaminer, du skal mindst vælge :min forskellige.', // todo translate
			'vitamins.max'          => 'Du har valgt for mange vitaminer, du kan maksimalt vælge :max forskellige.', // todo translate
			'vitamins.exists'       => 'Du har valgt et vitamin som ikke findes, hvordan ved vi ikke, prøv igen.', // todo translate
		] );

		$vitamins = collect( $request->get( 'vitamins' ) );

		Cart::clear();
		Cart::addProduct('subscription');
		Cart::addProduct( 'shipping', 0 );

		if ( \Auth::check() && \Auth::user()->isUser() )
		{
			\Auth::user()
			     ->getCustomer()
			     ->setVitamins( $vitamins );

			\Auth::user()->getCustomer()->getPlan()->update(['price' => Cart::getTotal()]);

			return \Redirect::action( 'AccountController@getSettingsSubscription' )
			                ->with( 'success', 'Dine vitaminer blev opdateret!' ); // todo translate
		}

		\Session::forget( 'user_data' );
		\Session::forget('flow-completion-token');
		\Session::put( 'vitamins', $vitamins );
		\Session::put( 'product_name', 'subscription' );

		/** @var Vitamin $vitamin */
		$i = 0;
		foreach ( Vitamin::whereIn('id', $vitamins)->get() as $vitamin)
		{
			$i++;
			Cart::addProduct( \App\Apricot\Libraries\PillLibrary::$codes[$vitamin->code], '' );
			Cart::addInfo("vitamins.{$i}", $vitamin->code);
		}

		return \Redirect::action( 'CheckoutController@getCheckout' );
	}
}
