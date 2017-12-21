<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Repositories\CouponRepository;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;

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
			'coupons_active' => $this->repo->Active(),
			'coupons_inactive' => $this->repo->Inactive(),
		]);
	}

	function create() {
		return view('admin.coupons.manage');
	}

	function store(CouponRequest $request) {
		$coupon = new Coupon();

		$coupon->code = strtoupper($request->get('code'));
		$coupon->description = $request->get('description');
		$coupon->discount_type = $request->get('type');
		$coupon->ambas = $request->get('ambas');
		$coupon->for_second = $request->get('for_second');
		$coupon->automatic = $request->get('automatic');
		if($coupon->automatic_id != 0){
            $coupon->automatic_id = $request->get('automatic_id');
        }
        $coupon->length = $request->get('length');
		$coupon->currency = $request->get('currency');
		$coupon->discount = $request->get('type') == 'amount' ? MoneyLibrary::toCents($request->get('discount')) : $request->get('discount');
		$coupon->uses_left = $request->get('uses_left');
		$coupon->applies_to = $request->get('applies_to');
		$coupon->valid_from = $request->get('valid_from', Date::now()->format('Y-m-d'));
		$coupon->valid_to = $request->get('valid_to', Date::now()->addYears(99)->format('Y-m-d'));

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

		$coupon->code = strtoupper($request->get('code'));
		$coupon->description = $request->get('description');
		$coupon->discount_type = $request->get('type');
		$coupon->currency = $request->get('currency');
		$coupon->for_second = $request->get('for_second');
        $coupon->automatic = $request->get('automatic');
        if($coupon->automatic_id != 0){
            $coupon->automatic_id = $request->get('automatic_id');
        }
        $coupon->length = $request->get('length');
		$coupon->ambas = $request->get('ambas');
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
