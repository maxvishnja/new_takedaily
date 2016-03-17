<?php namespace App\Http\Controllers;

use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Repositories\CouponRepository;
use App\User;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;
use Stripe\Customer;
use Stripe\Stripe;

class CheckoutController extends Controller
{

	function __construct()
	{

	}

	function getCheckout(Request $request)
	{
		return view('checkout.index', [
			'combinations' => $request->session()->get('my_combinations'),
			'user_data'    => $request->session()->get('user_data')
		]);
	}

	function postCheckout(CouponRepository $couponRepository, Request $request)
	{
		Stripe::setApiKey(env('STRIPE_API_SECRET_KEY', ''));

		$stripeToken  = $request->get('stripeToken');
		$coupon       = $couponRepository->findByCoupon($request->get('coupon', ''));
		$userData     = json_decode($request->get('user_data', '{}'));
		$combinations = json_decode($request->get('combinations', '{"one":null,"two":null,"three":null}'));
		$info         = $request->get('info');
		$password     = str_random(8);

		$orderPrice = 149; // todo DON'T HARDCODE IT
		$subscriptionPrice = 149; // todo DON'T HARDCODE IT

		if ( $coupon )
		{
			if ( $coupon->discount_type == 'percentage' )
			{
				$orderPrice -= $orderPrice * ($coupon->discount / 100);
			}
			elseif ( $coupon->discount_type == 'amount' )
			{
				$orderPrice -= MoneyLibrary::toMoneyFormat($coupon->discount);
			}

			if( $coupon->applies_to == 'plan' )
			{
				$subscriptionPrice = $orderPrice;
			}
		}

		$user = User::create([
			'name'     => ucwords($info['name']),
			'email'    => strtolower($info['email']),
			'password' => bcrypt($password),
			'type'     => 'user'
		]);

		\Auth::login($user, true);

		$user->getCustomer()->setCustomerAttributes([
			'address_city'    => $info['address_city'],
			'address_line1'   => $info['address_street'],
			'address_country' => $info['address_country'],
			'address_postal'  => $info['address_zipcode']
		]);

		$stripeCustomer = Customer::create([
			"description" => "Customer for {$user->getEmail()}",
			"source"      => $stripeToken
		]);

		$user->getCustomer()->getPlan()->update([
			'stripe_token'            => $stripeCustomer->id,
			'price'                   => MoneyLibrary::toCents($subscriptionPrice),
			'price_shipping'          => 0,
			'subscription_started_at' => Date::now(),
			'subscription_rebill_at'  => Date::now()->addMonth()
		]);

		$stripeCharge = $user->getCustomer()->charge(MoneyLibrary::toCents($orderPrice), true);

		if ( !$stripeCharge )
		{
			return \Redirect::back()->withErrors([ ])->withInput();
		}

		if( $coupon )
		{
			$coupon->reduceUsagesLeft();
		}

		return \Redirect::action('CheckoutController@getSuccess');
	}

	function getSuccess()
	{
		return view('checkout.success');
	}

	function applyCoupon(CouponRepository $couponRepository, Request $request)
	{
		if ( is_null($request->get('coupon')) || $request->get('coupon') == '' )
		{
			return \Response::json([ 'message' => 'Du skal indtaste en kuponkode.' ], 400);
		}

		$coupon = $couponRepository->findByCoupon($request->get('coupon'));

		if ( !$coupon )
		{
			return \Response::json([ 'message' => 'Kuponkoden findes ikke.' ], 400);
		}

		return \Response::json([
			'message' => 'Kuponkoden blev tilføjet!',
			'coupon'  => [
				'description'   => $coupon->description,
				'applies_to'    => $coupon->applies_to,
				'discount_type' => $coupon->discount_type,
				'discount'      => $coupon->discount,
				'code'          => $coupon->code
			]
		], 200);
	}
	
}