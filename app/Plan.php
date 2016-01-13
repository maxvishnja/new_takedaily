<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Date\Date;

/**
 * Class Plan
 * @package App
 *
 * @property integer id
 * @property string stripe_token
 * @property integer price
 * @property integer price_shipping
 * @property mixed subscription_started_at
 * @property mixed subscription_cancelled_at
 * @property mixed subscription_paused_at
 * @property mixed subscription_rebill_at
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class Plan extends Model
{

	use SoftDeletes;

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'plans';
	
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

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function products()
	{
		return $this->hasMany('App\PlanProduct', 'plan_id', 'id');
	}

	/**
	 * @return mixed
	 */
	public function getProducts()
	{
		return $this->products;
	}

	public function isActive()
	{
		return !$this->isPaused() && !$this->isCancelled();
	}

	public function isCancelled()
	{
		return !is_null($this->getSubscriptionCancelledAt());
	}

	public function isPaused()
	{
		return !is_null($this->getSubscriptionPausedAt());
	}

	public function pause()
	{
		$this->subscription_paused_at = Date::now();
		$this->save();

		return true;
	}

	public function start()
	{
		$this->subscription_paused_at = null;
		$this->subscription_cancelled_at = null;
		$this->subscription_rebill_at = Date::now()->addMonth();
		$this->save();

		return true;
	}

	public function getSubscriptionPausedAt()
	{
		return $this->subscription_paused_at;
	}

	public function getSubscriptionCancelledAt()
	{
		return $this->subscription_cancelled_at;
	}

	public function getSubscriptionStartedAt()
	{
		return $this->subscription_started_at;
	}

	public function getRebillAt()
	{
		return $this->subscription_rebill_at;
	}

	public function getTotal()
	{
		return $this->getPrice() + $this->getShippingPrice();
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function getShippingPrice()
	{
		return $this->price_shipping;
	}

	public function getStripeToken()
	{
		return $this->stripe_token;
	}

}