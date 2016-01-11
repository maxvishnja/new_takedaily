<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

	use SoftDeletes;

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'orders';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'customer_id',
		'reference',
		'state',
		'stripe_charge_token',
		'total',
		'sub_total',
		'total_shipping',
		'sub_total_shipping',
		'total_taxes'
	];
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];

	public function lines()
	{
		return $this->hasMany('App\OrderLine', 'order_id', 'id');
	}

	public function getPaddedId()
	{
		return str_pad($this->id, 11, 0, STR_PAD_LEFT);
	}

	public function getTotal() {
		return $this->total;
	}

	public function getSubTotal() {
		return $this->sub_total;
	}

	public function getTotalShipping() {
		return $this->total_shipping;
	}

	public function getSubTotalShipping() {
		return $this->sub_total_shipping;
	}

	public function getTotalTaxes() {
		return $this->total_taxes;
	}


}