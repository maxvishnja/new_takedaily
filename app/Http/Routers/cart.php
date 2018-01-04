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
	$coupon     = null;
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
				'amount'      => $coupon->discount_type == 'amount' ? \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat( $coupon->discount ) : $coupon->discount,
				'applies_to'  => $coupon->applies_to,
				'description' => $coupon->description,
				'code'        => $coupon->code,
                 'length'     => $coupon->length
			];
		}
	}

	// Get giftcard
	$giftcardData = [];
	if ( ! $coupon && \Session::has( 'giftcard_id' ) && \Session::has( 'giftcard_token' ) && \Session::get( 'product_name', 'subscription' ) == 'subscription' )
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

Route::post( '/cart-pick-n-mix', function ( \Illuminate\Http\Request $request )
{
	\App\Apricot\Checkout\Cart::empty();
	\App\Apricot\Checkout\Cart::addProduct( 'subscription' );

	$vitamins = $request->get( 'vitamins', [] );

	$i = 0;
	foreach ( $vitamins as $vitamin )
	{
		$i ++;
		$price = null;
		if ($i > 3)
		{
			$price = \App\Apricot\Checkout\ProductPriceGetter::getPrice('vitamin');
		}
		\App\Apricot\Checkout\Cart::addProduct( \App\Apricot\Helpers\PillName::get( $vitamin ), $price, [ 'key' => "vitamin.{$vitamin}" ] );
		\App\Apricot\Checkout\Cart::addInfo( "vitamins.{$vitamin}", $vitamin );
	}

	if ( count( $vitamins ) < 3 )
	{
		for ( $i = count( $vitamins ); $i < 3; $i ++ )
		{
			\App\Apricot\Checkout\Cart::deductProduct( 'vitamin' );
		}
	}

	\App\Apricot\Checkout\Cart::addProduct( 'shipping', 0 );

	return Response::json( [ 'Ok' ] );
} );
