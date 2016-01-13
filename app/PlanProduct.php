<?php namespace App; 

use Illuminate\Database\Eloquent\Model;

class PlanProduct extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'plan_products';
	
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

	public function product()
	{
		return $this->hasOne('App\Product', 'id', 'product_id');
	}

}