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
 * @property mixed subscription_snoozed_until
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
		return !$this->isCancelled();
	}

	public function isCancelled()
	{
		return !is_null($this->getSubscriptionCancelledAt());
	}

	public function isSnoozed()
	{
		if( !is_null($this->getSubscriptionSnoozedUntil()) && Date::createFromFormat('Y-m-d H:i:s', $this->getSubscriptionSnoozedUntil())->diffInSeconds() <= 0 )
		{
			$this->subscription_snoozed_until = null;
			$this->save();
		}

		return !is_null($this->getSubscriptionSnoozedUntil());
	}

	public function snooze($days = 7)
	{
		$newDate = Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt())->addDays($days);

		$this->subscription_snoozed_until = $newDate;
		$this->subscription_rebill_at = $newDate;
		$this->save();

		return true;
	}

	public function isSnoozeable()
	{
		return $this->isActive() && Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt())->diffInDays() > 7; // consider should only be allowed once?
	}

	public function isCancelable()
	{
		return Date::createFromFormat('Y-m-d H:i:s', $this->getSubscriptionStartedAt())->diffInDays() >= 1;
	}

	public function start()
	{
		$this->subscription_snoozed_until = null;
		$this->subscription_cancelled_at = null;
		$this->subscription_rebill_at = Date::now()->addMonth();
		$this->save();

		return true;
	}

	public function getSubscriptionSnoozedUntil()
	{
		return $this->subscription_snoozed_until;
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