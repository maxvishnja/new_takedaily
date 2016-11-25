<?php

Route::get( '/flow', function ( \Illuminate\Http\Request $request )
{
	$giftcard = null;

	if ( \Session::has( 'giftcard_id' ) && \Session::has( 'giftcard_token' ) && \Session::get( 'product_name', 'subscription' ) == 'subscription' )
	{
		$giftcard = \App\Giftcard::where( 'id', \Session::get( 'giftcard_id' ) )
		                         ->where( 'token', \Session::get( 'giftcard_token' ) )
		                         ->where( 'is_used', 0 )
		                         ->where( 'currency', trans( 'general.currency' ) )
		                         ->first();
	}

	$product = \App\Product::whereName( 'subscription' )
	                       ->first();

	// Coupon
	$coupon = null;
	if ( \Session::has( 'applied_coupon' ) )
	{
		$couponRepository = new \App\Apricot\Repositories\CouponRepository();
		$coupon           = $couponRepository->findByCoupon( \Session::get( 'applied_coupon' ) );
	}

	$zone          = new \App\Apricot\Libraries\TaxLibrary( trans( 'general.tax_zone' ) );
	$taxRate       = $zone->rate();
	$shippingPrice = \App\Setting::getWithDefault( 'shipping_price', 0 );

	$userData = [];
	$delay    = 3200;

	if ( $request->has( 'token' ) )
	{
		$flowCompletion = \App\FlowCompletion::whereToken( $request->get( 'token' ) )->first();

		if ( $flowCompletion )
		{
			$userData = $flowCompletion->user_data;
			$delay    = 0;
		}
	}

	return view( 'flow', compact( 'giftcard', 'coupon', 'product', 'taxRate', 'shippingPrice', 'userData', 'delay' ) );
} )->name( 'flow' );

Route::post( 'flow/send-recommendation', function ( \Illuminate\Http\Request $request )
{
	// todo validate has email and token
	$to = $request->get( 'email' );

	Mail::queue( 'emails.recommendation', [ 'locale' => App::getLocale(), 'token' => $request->get( 'token' ) ], function ( \Illuminate\Mail\Message $message ) use ( $to )
	{
		$message->to( $to );
		$message->subject( trans( 'mails.recommendation.subject' ) );
	} );

	return Response::json( [ 'message' => 'mail added to queue' ] );
} )->name( 'send-flow-recommendations' );

Route::post( 'flow/recommendations', function ( \Illuminate\Http\Request $request )
{
	$lib = new \App\Apricot\Libraries\CombinationLibrary();

	$lib->generateResult( json_decode( $request->get( 'user_data' ) ) );

	$advises = '';

	foreach ( $lib->getAdvises() as $adviseKey => $advise )
	{
		$advises .= '<p class="advise-paragraph" data-key="' . $adviseKey . '">' . $advise . '</p>';
	}

	$codes = [];

	foreach ( $lib->getResult() as $combKey => $combVal )
	{
		$codes[] = \App\Apricot\Libraries\PillLibrary::getPill( $combKey, $combVal );
	}

	/** @var \App\FlowCompletion $flowCompletion */
	$flowCompletion = \App\FlowCompletion::generateNew( $request->get( 'user_data', '{}' ) );

	$request->session()->set( 'flow-completion-token', $flowCompletion->token );

	$ingredients = '';
	$alphabet    = range( 'a', 'c' );

	\App\Apricot\Checkout\Cart::clear();
	\App\Apricot\Checkout\Cart::addProduct( 'subscription' );
	\App\Apricot\Checkout\Cart::addProduct( 'shipping', 0 );

	foreach ( $lib->getResult() as $index => $combination )
	{
		$combinationKey = $combination;
		$indexOld       = $index;

		if ( $index == 'one' )
		{
			$combination = $alphabet[ $combination - 1 ];
		}

		switch ( $index )
		{
			case 'one':
				$index = 1;
				break;
			case 'two':
				$index = 2;
				break;
			case 'three':
			default:
				$index = 3;
				break;
		}

		$vitamin_code = \App\Apricot\Libraries\PillLibrary::getPill( $indexOld, $combinationKey );

		$ingredients .= '<div class="ingredient_item" data-grouptext="' . $indexOld . '" data-groupnum="' . $index . '" data-item="' . $index . $combination . '">
					<span class="icon icon-arrow-down"></span>
					<h3>' . ( isset( \App\Apricot\Libraries\PillLibrary::$codes[ $vitamin_code ] ) ? \App\Apricot\Libraries\PillLibrary::$codes[ $vitamin_code ] : $vitamin_code ) . '</h3>
					' . view( 'flow-includes.views.vitamin_table', [ 'label' => strtolower( "{$index}{$combination}" ) ] ) . '
				</div>';

		\App\Apricot\Checkout\Cart::addProduct( \App\Apricot\Libraries\PillLibrary::$codes[ $vitamin_code ], '', [ 'key' => "vitamin.{$index}" ] );
		\App\Apricot\Checkout\Cart::addInfo( "vitamins.{$index}", $vitamin_code );
	}

	\App\Apricot\Checkout\Cart::addInfo( "user_data", json_decode( $request->get( 'user_data' ) ) );

	return Response::json( [
		'advises'        => $advises,
		'num_advises'    => count( $lib->getAdvises() ),
		'label'          => view( 'flow-label', [ 'combinations' => $lib->getResult(), 'advises' => $lib->getAdviseInfos() ] )->render(),
		'selected_codes' => implode( ',', $codes ),
		'result'         => $lib->getResult(),
		'vitamin_info'   => $ingredients,
		'token'          => $flowCompletion->token
	] );
} )->name( 'flow-recommendations' );

Route::post( 'flow', function ( \Illuminate\Http\Request $request )
{
	$userData = json_decode( $request->get( 'user_data' ) );

	if ( Auth::check() && Auth::user()->isUser() && $request->get( 'update_only', 0 ) == 1 )
	{
		Auth::user()->getCustomer()->unsetAllUserdata();
		Auth::user()->getCustomer()->updateUserdata( $userData );
		Auth::user()->getCustomer()->getPlan()->setIsCustom( false );
		Auth::user()->getCustomer()->getPlan()->update( [ 'price' => \App\Apricot\Checkout\Cart::getTotal() ] );

		$combinations = Auth::user()->getCustomer()->calculateCombinations();
		$vitamins     = [];

		foreach ( $combinations as $key => $combination )
		{
			$pill    = \App\Apricot\Libraries\PillLibrary::getPill( $key, $combination );
			$vitamin = \App\Vitamin::select( 'id' )->whereCode( $pill )->first();

			if ( $vitamin )
			{
				$vitamins[] = $vitamin->id;
			}
		}
		Auth::user()->getCustomer()->setVitamins( $vitamins );

		\App\Apricot\Checkout\Cart::clear();

		return \Redirect::action( 'AccountController@getSettingsSubscription' )
		                ->with( 'success', trans( 'flow.package-updated' ) );
	}
	else
	{
		if ( Auth::check() && Auth::user()->isUser() )
		{
			Auth::logout();
		}

		Session::forget( 'vitamins' );
		Session::forget( 'package' );
		Session::put( 'user_data', $userData );
		Session::put( 'product_name', $request->get( 'product_name' ) );
		Session::put( 'flow-completion-token', $request->get( 'flow-token' ) );

		return Redirect::action( 'CheckoutController@getCheckout' );
	}
} )->name( 'flow-post' );

Route::post( 'flow-upsell', function ( \Illuminate\Http\Request $request )
{
	if ( ! $request->get( 'upsell_token' ) == Session::get( 'upsell_token' ) || ! Session::has( 'upsell_token' ) )
	{
		return Redirect::to( '/flow' );
	}

	\Auth::logout();

	$coupon = \App\Coupon::newUpsellCoupon();

	Session::put( 'applied_coupon', $coupon->code );
	Session::forget( 'flow-completion-token' );

	return Redirect::to( '/flow' );
} )->name( 'flow-upsell' );
