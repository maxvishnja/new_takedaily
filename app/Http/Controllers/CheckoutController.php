<?php namespace App\Http\Controllers;

use App\Apricot\Checkout\Checkout;
use App\Apricot\Checkout\CheckoutCompletion;
use App\Apricot\Helpers\PaymentMethods;
use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Libraries\TaxLibrary;
use App\Apricot\Repositories\CouponRepository;
use App\Giftcard;
use App\Http\Requests\CheckoutRequest;
use App\Product;
use App\Setting;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

	function __construct()
	{
	}

	function getCheckout( Request $request )
	{
		\Session::set( 'product_name', $request->get( 'product_name', \Session::get( 'product_name', 'subscription' ) ) );

		if ( \Session::get( 'product_name' ) == 'subscription' && ( ! \Session::has( 'user_data' ) && ! \Session::has( 'vitamins' ) ) )
		{
			return \Redirect::route( 'flow' )->withErrors( [ trans( 'checkout.messages.vitamins-not-selected' ) ] );
		}

		$giftcard = null;

		if ( \Session::has( 'giftcard_id' ) && \Session::has( 'giftcard_token' ) && \Session::get( 'product_name' ) == 'subscription' )
		{
			$giftcard = Giftcard::where( 'id', \Session::get( 'giftcard_id' ) )
			                    ->where( 'token', \Session::get( 'giftcard_token' ) )
			                    ->where( 'is_used', 0 )
			                    ->first();
		}

		$product = Product::where( 'name', \Session::get( 'product_name', 'subscription' ) )->first();

		if ( ! $product )
		{
			return \Redirect::route( 'home' );
		}

		$codes = [];

		if ( $request->session()->has( 'user_data' ) )
		{
			$lib = new \App\Apricot\Libraries\CombinationLibrary();

			$userData = $request->session()->get( 'user_data' );

			if( json_decode($userData))
			{
				$userData = json_decode($userData);
			}

			$lib->generateResult( $userData );

			foreach ( $lib->getResult() as $combKey => $combVal )
			{
				$codes[] = \App\Apricot\Libraries\PillLibrary::getPill( $combKey, $combVal );
			}
		}
		elseif($request->session()->has('vitamins'))
		{
			$codes = $request->session()->get('vitamins');
		}

		return view( 'checkout.index', [
			'user_data'     => json_encode( \Session::get( 'user_data', \Request::old( 'user_data', json_decode( '{}' ) ) ) ),
			'product'       => $product,
			'giftcard'      => $giftcard,
			'shippingPrice' => Setting::getWithDefault( 'shipping_price', 0 ),
			'codes'         => $codes,
		    'paymentMethods' => PaymentMethods::getAcceptedMethodsForCountry(\App::getLocale())
		] );
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	function getTaxRate( Request $request )
	{
		$zone = new TaxLibrary( $request->get( 'zone' ) );

		return \Response::json( [ 'rate' => $zone->rate() ] );
	}

	/**
	 * @param CheckoutRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	function postCheckout( CheckoutRequest $request )
	{
		$productName   = $request->get( 'product_name', 'subscription' );
		$paymentMethod = $request->get( 'payment_method' );
		$couponCode    = $request->get( 'coupon', '' );

		$checkout = new Checkout();

		$checkout->setProductByName( $productName )
		         ->setPaymentMethod( $paymentMethod )
		         ->setupTotals( $request )
		         ->appendCoupon( $couponCode )
		         ->appendGiftcard( $request->session()->get( 'giftcard_id' ), $request->session()->get( 'giftcard_token' ) )
		         ->setTaxLibrary( $request->get( 'address_country' ) )
		         ->createCustomer( $request->get( 'name' ), $request->get( 'email' ) );

		if ( ! $checkout->getCustomer() )
		{
			return \Redirect::back()
			                ->withErrors( 'Der skete en fejl under betalingen, prøv igen.' )
			                ->withInput();// todo translate
		}

		if ( ! $charge = $checkout->makeInitialPayment() )
		{
			return \Redirect::back()
			                ->withErrors( 'Der skete en fejl under betalingen, prøv igen.' )
			                ->withInput();// todo translate
		}

		$request->session()->put( 'charge_id', $charge->id );
		$request->session()->put( 'payment_customer_id', $checkout->getCustomer()->id );
		$request->session()->put( 'name', $request->get( 'name' ) );
		$request->session()->put( 'email', $request->get( 'email' ) );
		$request->session()->put( 'address_street', $request->get( 'address_street' ) );
		$request->session()->put( 'address_city', $request->get( 'address_city' ) );
		$request->session()->put( 'address_zipcode', $request->get( 'address_zipcode' ) );
		$request->session()->put( 'address_country', $request->get( 'address_country' ) );
		$request->session()->put( 'company', $request->get( 'company' ) );
		$request->session()->put( 'product_name', $request->get( 'product_name' ) );
		$request->session()->put( 'user_data', $request->get( 'user_data' ) );
		$request->session()->put( 'price', $checkout->getSubscriptionPrice() );
		$request->session()->put( 'order_price', $checkout->getTotal() );

		// Redirect
		if ( isset( $charge->links ) && isset( $charge->links->paymentUrl ) )
		{
			return \Redirect::to( $charge->links->paymentUrl );
		}

		return \Redirect::action( 'CheckoutController@getVerify', [ 'method' => $request->get( 'payment_method' ) ] );
	}

	/**
	 * @param                          $method
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	function getVerify( $method, Request $request )
	{
		$productName = $request->session()->get( 'product_name', 'subscription' );
		$couponCode  = $request->session()->get( 'coupon', '' );

		$checkout = new Checkout();
		$checkout->setPaymentMethod( $method )
		         ->setProductByName( $productName )
		         ->setupTotals( $request )
		         ->appendCoupon( $couponCode )
		         ->appendGiftcard( $request->session()->get( 'giftcard_id' ), $request->session()->get( 'giftcard_token' ) )
		         ->setTaxLibrary( $request->session()->get( 'address_country' ) );

		$isSuccessful = $checkout->getPaymentHandler()->isChargeValid( $request->session()->get( 'charge_id' ) );

		if ( ! $isSuccessful )
		{
			return \Redirect::action( 'CheckoutController@getCheckout' )
			                ->withErrors( 'Der skete en fejl under betalingen, prøv igen!' )
			                ->withInput( [
				                'name'            => $request->session()->get( 'name' ),
				                'email'           => $request->session()->get( 'email' ),
				                'address_street'  => $request->session()->get( 'address_street' ),
				                'address_city'    => $request->session()->get( 'address_city' ),
				                'address_country' => $request->session()->get( 'address_country' ),
				                'company'         => $request->session()->get( 'company' )
			                ] ); // todo translate
		}

		$checkoutCompletion = new CheckoutCompletion( $checkout );

		$password = str_random( 8 );
		$name     = $request->session()->get( 'name' );
		$email    = $request->session()->get( 'email' );

		$checkoutCompletion->createUser( $name, $email, $password )
		                   ->setCustomerAttributes( [
			                   'address_city'    => $request->session()->get( 'address_city' ),
			                   'address_line1'   => $request->session()->get( 'address_street' ),
			                   'address_country' => $request->session()->get( 'address_country' ),
			                   'address_postal'  => $request->session()->get( 'address_zipcode' ),
			                   'company'         => $request->session()->get( 'company' ),
		                   ] )
		                   ->setPlanPayment( $request->session()->get( 'payment_customer_id' ), $method )
		                   ->setUserData( $request->session()->get( 'user_data', '{}' ) )
		                   ->updateCustomerPlan()
		                   ->handleProductActions()
		                   ->deductCouponUsage()
		                   ->markGiftcardUsed()
		                   ->fireCustomerWasBilled( $request->session()->get( 'charge_id' ) )
		                   ->queueEmail( $password )
		                   ->flush()
		                   ->initUpsell()
		                   ->loginUser();

		// fixme userData being null/false if failed somewhere.

		if ( $checkout->getProduct()->isSubscription() )
		{
			return \Redirect::action( 'CheckoutController@getSuccess' )
			                ->with( [ 'order_created' => true, 'upsell' => true ] );
		}

		return \Redirect::action( 'CheckoutController@getSuccessNonSubscription', [ 'token' => $checkoutCompletion->getGiftcard()->token ] )
		                ->with( [ 'order_created' => true ] );
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	function getSuccess( Request $request )
	{
		if ( ! $request->session()->has( 'order_created' ) )
		{
			return \Redirect::route( 'home' );
		}

		$vitamins = \Auth::user()->getCustomer()->getVitaminModels();

		return view( 'checkout.success', [ 'vitamins' => $vitamins ] );
	}

	/**
	 * @param                          $token
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	function getSuccessNonSubscription( $token, Request $request )
	{
		if ( ! $request->session()->has( 'order_created' ) )
		{
			return \Redirect::route( 'home' );
		}

		return view( 'checkout.success', [
			'giftcardToken' => $token
		] );
	}

	/**
	 * @param \App\Apricot\Repositories\CouponRepository $couponRepository
	 * @param \Illuminate\Http\Request                   $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	function applyCoupon( CouponRepository $couponRepository, Request $request )
	{ // todo use a checkout model
		if ( is_null( $request->get( 'coupon' ) ) || $request->get( 'coupon' ) == '' )
		{
			return \Response::json( [ 'message' => trans( 'checkout.messages.coupon-missing' ) ], 400 );
		}

		$coupon = $couponRepository->findByCoupon( $request->get( 'coupon' ) );

		if ( ! $coupon )
		{
			return \Response::json( [ 'message' => trans( 'checkout.messages.no-such-coupon' ) ], 400 );
		}

		/** @var Product $product */
		$product = Product::where( 'name', \Session::get( 'product_name', 'subscription' ) )->first();

		if ( ! $product || $product->isGiftcard() )
		{
			return \Response::json( [ 'message' => trans( 'checkout.messages.no-such-coupon' ) ], 400 );
		}

		\Session::put( 'applied_coupon', $coupon->code );

		return \Response::json( [
			'message' => trans( 'checkout.messages.coupon-added' ),
			'coupon'  => [
				'description'   => $coupon->description,
				'applies_to'    => $coupon->applies_to,
				'discount_type' => $coupon->discount_type,
				'discount'      => $coupon->discount,
				'code'          => $coupon->code
			]
		], 200 );
	}

}