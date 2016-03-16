<?php namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

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

	function postCheckout(Request $request)
	{
		dd($request->all());
	}

	function applyCoupon(Request $request)
	{
		if ( is_null($request->get('coupon')) || $request->get('coupon') == '' )
		{
			return \Response::json([ 'message' => 'Du skal indtaste en kuponkode.' ], 400);
		}

		$coupon = Coupon::where('code', strtoupper($request->get('coupon', '')))->where(function ($query)
		{
			$query->where('uses_left', '-1')
				  ->orWhere('uses_left', '>=', 1);
		})->where(function ($query)
		{
			$query->where('valid_from', '<=', date('Y-m-d'))
				  ->where('valid_to', '>=', date('Y-m-d'));
		})->first();

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