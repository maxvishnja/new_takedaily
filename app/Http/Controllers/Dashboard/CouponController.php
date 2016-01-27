<?php

namespace App\Http\Controllers\Dashboard;

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

	function store() { }

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

	function update($id)
	{
		$coupon = Coupon::find($id);

		if ( !$coupon )
		{
			return \Redirect::back()->withErrors("Kuponkoden (#{$id}) kunne ikke findes!");
		}

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
