<?php
/*
 * Buy giftcard
 */
Route::get( 'gifting', function ()
{
	return view( 'gifting' );
} )->name( 'gifting' );

Route::post( 'buy-giftcard', function ( \Illuminate\Http\Request $request )
{
	$validator = Validator::make( $request->all(), [
		'giftcard' => 'required|in:1,3,6'
	] );

	if ( $validator->fails() )
	{
		return redirect()->back()->withErrors( $validator->errors() );
	}
    \Auth::logout();
	\Session::forget( 'applied_coupon' );
	\Session::forget( 'user_data' );
	\Session::forget( 'flow-completion-token' );
	\Session::forget( 'vitamins' );
	\Session::set( 'product_name', "giftcard_{$request->get('giftcard')}" );

	\App\Apricot\Checkout\Cart::clear();
	\App\Apricot\Checkout\Cart::addProduct( "giftcard_{$request->get('giftcard')}" );

	return Redirect::action( 'CheckoutController@getCheckout' );
} )->name( 'buy-giftcard' );

/*
 * Use giftcard
 */
Route::get( 'gc/{token}', function ( $token, \Illuminate\Http\Request $request )
{
	$giftcard = \App\Giftcard::where( 'token', $token )
	                         ->where( 'is_used', 0 )
	                         ->first();

	if ( ! $giftcard )
	{
		abort( 404 );
	}

	if ( $giftcard->currency != trans( 'general.currency' ) )
	{
		abort( 404, 'The giftcard is not available in this currency/language. Please switch to the correct store.' );
	}

	$request->session()
	        ->put( 'giftcard_id', $giftcard->id );
	$request->session()
	        ->put( 'giftcard_token', $giftcard->token );

	return Redirect::to( 'flow' )
	               ->with( 'success', trans( 'message.success.giftcard-applied' ) );
} );

Route::get( '/use-giftcard', function ()
{
	return view( 'use-giftcard' );
} );

Route::post( '/use-giftcard', function ( \Illuminate\Http\Request $request )
{
	$validator = Validator::make( $request->all(), [
		'giftcard_code' => 'required|exists:giftcards,token'
	] );

	if ( $validator->fails() )
	{
		return redirect()->back()->withErrors( $validator->messages() );
	}

	$giftcard = \App\Giftcard::whereToken( $request->get( 'giftcard_code' ) )->whereIsUsed( 0 )->whereCurrency( trans( 'general.currency' ) )->first();

	if ( ! $giftcard )
	{
		return redirect()->back()->withErrors( [ trans( 'use-gifting.failed' ) ] );
	}

	Session::put( 'giftcard_id', $giftcard->id );
	Session::put( 'giftcard_token', $giftcard->token );

	return Redirect::route( 'flow' )->with( 'success', trans( 'use-gifting.success' ) );
} )->name( 'use-giftcard-post' );