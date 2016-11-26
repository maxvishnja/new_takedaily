<?php
Route::get( '/cart', function ()
{
	// Generate lines
	$lines = \App\Apricot\Checkout\Cart::get()->map( function ( $item )
	{
		if ( Lang::has( "products.{$item->name}" ) )
		{
			$item->name = trans( "products.{$item->name}" );
		}
		else
		{
			$item->hidePrice = true;
		}

		$item->amount = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat( $item->amount );

		return $item;
	} );

	// Get coupon
	$couponData = [];
	$coupon = null;
	if ( \Session::has( 'applied_coupon' ) )
	{
		$couponRepository = new \App\Apricot\Repositories\CouponRepository();
		/** @var \App\Coupon|null $coupon */
		$coupon = $couponRepository->findByCoupon( \Session::get( 'applied_coupon' ) );

		if ( $coupon )
		{
			$couponData = [
				'applied'     => true,
				'type'        => $coupon->discount_type,
				'amount'      => $coupon->discount_type == 'amount' ? \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($coupon->discount) : $coupon->discount,
				'applies_to'  => $coupon->applies_to,
				'description' => $coupon->description,
				'code'        => $coupon->code
			];
		}
	}

	// Get giftcard
	$giftcardData = [];
	if ( !$coupon && \Session::has( 'giftcard_id' ) && \Session::has( 'giftcard_token' ) && \Session::get( 'product_name', 'subscription' ) == 'subscription' )
	{
		$giftcard = \App\Giftcard::where( 'id', \Session::get( 'giftcard_id' ) )
		                         ->where( 'token', \Session::get( 'giftcard_token' ) )
		                         ->where( 'is_used', 0 )
		                         ->whereCurrency( trans( 'general.currency' ) )
		                         ->first();

		if ( $giftcard )
		{
			$giftcardData = [
				'worth' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat( $giftcard->worth )
			];
		}
	}

	return Response::json( [ 'lines' => $lines, 'info' => \App\Apricot\Checkout\Cart::getInfo(), 'coupon' => $couponData, 'giftcard' => $giftcardData ] );
} );

Route::post( '/cart-deduct/{vitaminGroup}', function ( $vitaminGroup )
{
	switch ( $vitaminGroup )
	{
		case 1:
		case 'one':
			$vitaminGroup = 1;
			break;

		case 2:
		case 'two':
			$vitaminGroup = 2;
			break;

		default:
		case 3:
		case 'three':
		case 'four':
		case 'five':
			$vitaminGroup = 3;
			break;
	}


	if ( \App\Apricot\Checkout\Cart::hasInfo( "vitamins.{$vitaminGroup}" ) )
	{
		\App\Apricot\Checkout\Cart::deductProduct( 'vitamin' );
		\App\Apricot\Checkout\Cart::removeProduct( "vitamin.{$vitaminGroup}" );
		\App\Apricot\Checkout\Cart::removeInfo( "vitamins.{$vitaminGroup}" );
	}

	return Response::json( [ 'message' => 'Ok' ] );
} );