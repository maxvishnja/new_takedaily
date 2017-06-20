<?php
Route::group( [ 'middleware' => [ 'secure' ], 'prefix' => 'checkout' ], function ()
{
	Route::get( '', 'CheckoutController@getCheckout' );
	Route::post( '', 'CheckoutController@postCheckout' );
	Route::post( 'apply-coupon', 'CheckoutController@applyCoupon' );
	Route::get( 'get-taxrate', 'CheckoutController@getTaxRate' );
	Route::post( 'almost-customer', 'CheckoutController@setAlmostCustomer' );

	// Charge verify
	Route::get( 'verify/{method}/{id}', 'CheckoutController@getVerify' )->name( 'checkout-verify-method' );

	// Mollie webhook
	Route::post( 'mollie', function ( $paymentId = 0 )
	{
		try
		{
			$payment = Mollie::api()
			                 ->payments()
			                 ->get( $paymentId );
			Log::info( $payment ); // todo make this work......
		} catch ( Mollie_API_Exception $ex )
		{
			Log::error( $ex->getMessage() );
		}

	} )->name( 'checkout-webhook-mollie' );
} );

Route::group( [ 'prefix' => 'checkout' ], function ()
{
	Route::get( 'success', 'CheckoutController@getSuccess' );
	Route::get( 'success-giftcard/{token}', 'CheckoutController@getSuccessNonSubscription' );
} );