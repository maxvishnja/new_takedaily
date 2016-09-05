<?php

namespace App;

use App\Apricot\Libraries\MoneyLibrary;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property integer $id
 * @property string $name
 * @property boolean $is_subscription
 * @property integer $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereIsSubscription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

	public function isGiftcard()
	{ // eww fixme
		return strpos($this->name, 'giftcard') !== false;
	}
}
