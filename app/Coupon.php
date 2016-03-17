<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'coupons';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [ ];
	
	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden = [ ];

	function usage()
	{
		return $this->applies_to == 'order' ? 'ordren' : 'abonnentet'; // todo translate
	}

	function isAmount()
	{
		return $this->discount_type == 'amount';
	}

	function isPercentage()
	{
		return $this->discount_type == 'percentage';
	}

	function isFreeShipping()
	{
		return $this->discount_type == 'free_shipping';
	}

	function reduceUsagesLeft()
	{
		if( $this->uses_left > 0 )
		{
			$this->uses_left--;
			$this->save();
		}
	}

}