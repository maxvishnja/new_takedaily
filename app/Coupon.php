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

}