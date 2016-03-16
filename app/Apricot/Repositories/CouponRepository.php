<?php namespace App\Apricot\Repositories;

use App\Coupon;

class CouponRepository
{
	public function all()
	{
		return Coupon::orderBy('created_at', 'DESC')->get();
	}

	public function findByCoupon($coupon)
	{
		$coupon = strtoupper($coupon);

		if ( $coupon == '' )
		{
			return false;
		}

		return Coupon::where('code', $coupon)->where(function ($query)
		{
			$query->where('uses_left', '-1')
				  ->orWhere('uses_left', '>=', 1);
		})->where(function ($query)
		{
			$query->where('valid_from', '<=', date('Y-m-d'))
				  ->where('valid_to', '>=', date('Y-m-d'));
		})->first();
	}
}