<?php

namespace App;

use App\Apricot\Libraries\MoneyLibrary;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'products';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'price',
		'is_subscription'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];

	public function getPriceAttribute($price)
	{
		return round(MoneyLibrary::convertCurrenciesByString(config('app.base_currency'), config('currency', config('app.base_currency')), $price));
	}

	public function isSubscription()
	{
		return $this->is_subscription == 1;
	}
}
