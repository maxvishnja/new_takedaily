<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Date\Date;

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
		'total_taxes',
		'shipping_name',
		'shipping_street',
		'shipping_city',
		'shipping_country',
		'shipping_zipcode',
		'shipping_company',
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

	public function customer()
	{
		return $this->hasOne('App\Customer', 'id', 'customer_id');
	}

	public function getPaddedId()
	{
		return str_pad($this->id, 11, 0, STR_PAD_LEFT);
	}

	public function getTotal()
	{
		return $this->total;
	}

	public function getSubTotal()
	{
		return $this->sub_total;
	}

	public function getTotalShipping()
	{
		return $this->total_shipping;
	}

	public function getSubTotalShipping()
	{
		return $this->sub_total_shipping;
	}

	public function getTotalTaxes()
	{
		return $this->total_taxes;
	}

	public function scopeToday($query)
	{
		return $query->whereBetween('created_at', [ Date::today()->setTime(0, 0, 0), Date::today()->setTime(23, 59, 59) ]);
	}

	public function markSent()
	{
		$this->state = 'sent';
		$this->save();

		// todo send mail to customer

		return true;
	}

	public function refund()
	{
		$this->lines()->create([
			'description'  => 'refund',
			'amount'       => $this->getSubTotal(),
			'tax_amount'   => $this->getTotalTaxes(),
			'total_amount' => $this->getTotal()
		]);
	}

	public function stateToColor()
	{
		switch ( $this->state )
		{
			case 'new':
				$color = 'warning';
				break;
			case 'sent':
				$color = 'info';
				break;
			case 'cancelled':
				$color = 'important';
				break;
			case 'paid':
				$color = 'success';
				break;
			case 'completed':
			default:
				$color = 'inverse';
				break;
		}

		return $color;
	}


}