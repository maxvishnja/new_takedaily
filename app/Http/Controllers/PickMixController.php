<?php

namespace App\Http\Controllers;

use App\Vitamin;
use Illuminate\Http\Request;

class PickMixController extends Controller
{
	public function get()
	{
		$vitamins         = Vitamin::all();
		$isCustomer       = \Auth::check() && \Auth::user()->isUser();
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
			'vitamins' => 'min:3|max:4|exists:vitamins,id'
		], [
			'vitamins.min' => 'Du har ikke valgt nok vitaminer, du skal mindst vælge 3 forskellige.', // todo translate
			'vitamins.max' => 'Du har valgt for mange vitaminer, du kan maksimalt vælge 4 forskellige.', // todo translate
			'vitamins.exists' => 'Du har valgt et vitamin som ikke findes, hvordan ved vi ikke, prøv igen.' // todo translate
		]);

		if ( \Auth::check() && \Auth::user()->isUser() )
		{
			\Auth::user()
			     ->getCustomer()
			     ->setVitamins($request->get('vitamins'));

			// todo return success
		}

		dd($request->get('vitamins', []));
	}
}
