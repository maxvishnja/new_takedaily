<?php namespace App\Apricot\Repositories;

use App\Coupon;

class CouponRepository
{
	public function all()
	{
		return Coupon::orderBy( 'created_at', 'DESC' )->get();
	}


	public function Active()
	{
		return Coupon::orderBy( 'created_at', 'DESC' )->where( 'valid_to', '>=', date( 'Y-m-d' ) )->get();
	}


	public function ActiveNotUpsell()
	{
		return Coupon::orderBy( 'created_at', 'DESC' )->where( 'valid_to', '>=', date( 'Y-m-d' ) )->where('description','!=','Upsell discount')->get();
	}


	public function Inactive()
	{
		return Coupon::orderBy( 'created_at', 'DESC' )->where( 'valid_to', '<=', date( 'Y-m-d' ) )->get();
	}


    public function AutomaticNL()
    {
        return Coupon::orderBy( 'created_at', 'DESC' )->where( 'automatic', 1 )->where('currency', 'EUR')->get();
    }

    public function AutomaticDK()
    {
        return Coupon::orderBy( 'created_at', 'DESC' )->where( 'automatic', 1 )->where()->get();
    }

	public function findByCoupon( $coupon )
	{
		$coupon = strtoupper( $coupon );

		if ( $coupon == '' )
		{
			return false;
		}

		return Coupon::where( 'code', $coupon )->where( function ( $query )
		{
			$query->where( 'uses_left', '-1' )
			      ->orWhere( 'uses_left', '>=', 1 );
		} )->where( function ( $query )
		{
			$query->where( 'valid_from', '<=', date( 'Y-m-d' ) )
			      ->where( 'valid_to', '>=', date( 'Y-m-d' ) );
		} )->where( 'currency', trans( 'general.currency' ) )
		             ->first();
	}

    public function findByCouponForSecond( $coupon )
    {
        $coupon = strtoupper( $coupon );

        if ( $coupon == '' )
        {
            return false;
        }

        return Coupon::where( 'code', $coupon )->where('for_second',1)->where( function ( $query )
        {
            $query->where( 'uses_left', '-1' )
                ->orWhere( 'uses_left', '>=', 1 );
        } )->where( function ( $query )
        {
            $query->where( 'valid_from', '<=', date( 'Y-m-d' ) )
                ->where( 'valid_to', '>=', date( 'Y-m-d' ) );
        } )->where( 'currency', trans( 'general.currency' ) )
            ->first();
    }
}