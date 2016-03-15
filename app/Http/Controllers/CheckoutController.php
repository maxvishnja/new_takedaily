<?php namespace App\Http\Controllers;

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
	
}