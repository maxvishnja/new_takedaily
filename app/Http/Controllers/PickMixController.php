<?php

namespace App\Http\Controllers;

use App\Vitamin;
use Illuminate\Http\Request;

class PickMixController extends Controller
{
	public function get()
	{
		$vitamins         = Vitamin::all();
		$isCustomer       = \Auth::check() && \Auth::user()
		                                           ->isUser();
		$selectedVitamins = [];

		if ( $isCustomer )
		{
			$selectedVitamins = json_decode(\Auth::user()
			                                     ->getCustomer()
			                                     ->getVitamins()); // consider is this foolproof? (what if it is not json, or such)
		}

		return view('pick', compact('vitamins', 'isCustomer', 'selectedVitamins'));
	}

	public function post(Request $request)
	{
		$this->validate($request, [
			'vitamins' => 'min:3|max:4'
		], [
			'vitamins.min' => 'Du har ikke valgt nok vitaminer, du skal mindst vælge 3 forskellige.', // todo translate
		    'vitamins.max' => 'Du har valgt for mange vitaminer, du kan maksimalt vælge 4 forskellige.' // todo translate
		]);

		dd($request->get('vitamins', []));
	}
}
