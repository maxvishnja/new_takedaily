<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Repositories\CouponRepository;
use App\Coupon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
	private $repo;

	function __construct(CouponRepository $repository)
	{
		$this->repo = $repository;
	}

	function index()
	{
		return view('admin.coupons.home', [
			'coupons' => $this->repo->all()
		]);
	}

	function create() {
		return view('admin.coupons.manage');
	}

	function store(Request $request) {
		$coupon = new Coupon();

		$coupon->code = $request->get('code');
		$coupon->description = $request->get('description');
		$coupon->discount_type = $request->get('type');
		$coupon->discount = $request->get('type') == 'amount' ? MoneyLibrary::toCents($request->get('discount')) : $request->get('discount');
		$coupon->uses_left = $request->get('uses_left');
		$coupon->applies_to = $request->get('applies_to');
		$coupon->valid_from = $request->get('valid_from');
		$coupon->valid_to = $request->get('valid_to');

		$coupon->save();

		return \Redirect::action('Dashboard\CouponController@index')->with('success', 'Kuponkoden blev oprettet!');
	}

	function edit($id)
	{
		$coupon = Coupon::find($id);

		if ( !$coupon )
		{
			return \Redirect::back()->withErrors("Kuponkoden (#{$id}) kunne ikke findes!");
		}

		return view('admin.coupons.manage', [
			'coupon' => $coupon
		]);
	}

	function update($id, Request $request)
	{
		$coupon = Coupon::find($id);

		if ( !$coupon )
		{
			return \Redirect::back()->withErrors("Kuponkoden (#{$id}) kunne ikke findes!");
		}

		$coupon->code = $request->get('code');
		$coupon->description = $request->get('description');
		$coupon->discount_type = $request->get('type');
		$coupon->discount = $request->get('type') == 'amount' ? MoneyLibrary::toCents($request->get('discount')) : $request->get('discount');
		$coupon->uses_left = $request->get('uses_left');
		$coupon->applies_to = $request->get('applies_to');
		$coupon->valid_from = $request->get('valid_from');
		$coupon->valid_to = $request->get('valid_to');

		$coupon->save();

		return \Redirect::action('Dashboard\CouponController@index')->with('success', 'Kuponkoden blev opdateret!');
	}

	function destroy($id)
	{
		$coupon = Coupon::find($id);

		if ( !$coupon )
		{
			return \Redirect::back()->withErrors("Kuponkoden (#{$id}) kunne ikke findes!");
		}

		$coupon->delete();

		return \Redirect::action('Dashboard\CouponController@index')->with('success', 'Kuponkoden blev slettet!');

	}
}
