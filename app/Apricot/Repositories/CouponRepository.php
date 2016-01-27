<?php namespace App\Apricot\Repositories;

use App\Coupon;

class CouponRepository
{
	public function all()
	{
		return Coupon::orderBy('created_at', 'DESC')->get();
	}
}