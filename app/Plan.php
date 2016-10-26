<?php namespace App;

use App\Apricot\Libraries\PaymentDelegator;
use App\Apricot\Libraries\PaymentHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Mail\Message;
use Jenssegers\Date\Date;

/**
 * Class Plan
 *
 * @package App
 * @property integer            $id
 * @property string             $payment_customer_token
 * @property string             $payment_method
 * @property integer            $price
 * @property integer            $price_shipping
 * @property mixed              $vitamins
 * @property string             $subscription_started_at
 * @property string             $subscription_cancelled_at
 * @property string             $subscription_snoozed_until
 * @property string             $subscription_rebill_at
 * @property \Carbon\Carbon     $created_at
 * @property \Carbon\Carbon     $updated_at
 * @property string             $deleted_at
 * @property-read \App\Customer $customer
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePaymentCustomerToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePaymentMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePriceShipping($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereVitamins($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionStartedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionCancelledAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionSnoozedUntil($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionRebillAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan rebillPending()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Plan notNotifiedPending()
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
	protected $fillable = [
		'payment_customer_token',
		'payment_method',
		'price',
		'price_shipping',
		'subscription_started_at',
		'subscription_cancelled_at',
		'subscription_snoozed_until',
		'subscription_rebill_at',
		'vitamins',
	    'is_custom'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function customer()
	{
		return $this->belongsTo('App\Customer', 'id', 'plan_id');
	}

	public function isActive()
	{
		return !$this->isCancelled() && !is_null($this->getRebillAt());
	}

	public function isCancelled()
	{
		return !is_null($this->getSubscriptionCancelledAt());
	}

	public function isSnoozed()
	{
		if ( !is_null($this->getSubscriptionSnoozedUntil()) && Date::createFromFormat('Y-m-d H:i:s', $this->getSubscriptionSnoozedUntil())
		                                                           ->diffInSeconds() <= 0
		)
		{
			$this->subscription_snoozed_until = null;
			$this->save();
		}

		return !is_null($this->getSubscriptionSnoozedUntil());
	}

	public function snooze($days = 7)
	{
		// consider checking if $this->isSnoozeable()
		$newDate = Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt())->addDays($days);

		$this->subscription_snoozed_until = $newDate;
		$this->subscription_rebill_at     = $newDate;
		$this->save();

		return true;
	}

	public function moveRebill($days = 1)
	{
		$newDate = Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt())->addDays($days);

		$this->subscription_rebill_at = $newDate;
		$this->save();

		return true;
	}

	public function isSnoozeable()
	{
		return $this->isActive()
		&& !$this->isSnoozed()
		&& Date::createFromFormat('Y-m-d H:i:s', $this->getSubscriptionStartedAt())->diffInDays() >= 4
		&& Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt()) > Date::now();
	}

	public function isCancelable()
	{
		return Date::createFromFormat('Y-m-d H:i:s', $this->getSubscriptionStartedAt())->diffInDays() >= 1
		&& Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt())->diffInDays() >= 4
		&& Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt()) > Date::now();
	}

	public function cancel()
	{
		$this->subscription_snoozed_until = null;
		$this->subscription_cancelled_at  = Date::now();
		$this->subscription_rebill_at     = null;
		$this->save();

		return true;
	}

	public function start()
	{
		$this->subscription_snoozed_until = null;
		$this->subscription_cancelled_at  = null;
		$this->subscription_rebill_at     = Date::now()->addMonth();
		$this->save();

		return true;
	}

	public function rebilled()
	{
		$this->subscription_rebill_at = Date::now()->addDays(28);
		$this->save();

		$this->markHasNotified(false);

		return true;
	}

	public function startFromToday()
	{
		$this->subscription_snoozed_until = null;
		$this->subscription_cancelled_at  = null;
		$this->subscription_rebill_at     = Date::now();
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

	public function getStripeToken() // todo remove
	{
		return $this->stripe_token;
	}

	public function getPaymentCustomerToken()
	{
		return $this->payment_customer_token;
	}

	/**
	 * Returns the payment method
	 *
	 * @return string
	 */
	public function getPaymentMethod()
	{
		return $this->payment_method;
	}

	public function getPaymentCustomer()
	{
		$customerToken = $this->getPaymentCustomerToken();

		$paymentMethod = new PaymentHandler(PaymentDelegator::getMethod($this->getPaymentMethod()));

		return $paymentMethod->getCustomer($customerToken);
	}

	/**
	 * @param Builder $query
	 *
	 * @return mixed
	 */
	public function scopeRebillPending($query)
	{
		return $query->where('subscription_rebill_at', '<=', Date::now()->addDays(4))
		             ->where(function (Builder $where)
		             {
			             $where->whereNull('subscription_snoozed_until')
			                   ->orWhere('subscription_snoozed_until', '<=', Date::now());
		             })
		             ->whereNull('subscription_cancelled_at');
	}

	/**
	 * @param Builder $query
	 *
	 * @return mixed
	 */
	public function scopeNotNotifiedPending($query)
	{
		return $query->where('has_notified_pending_rebill', 0);
	}

	private function markHasNotified($hasNotified = true)
	{
		$this->has_notified_pending_rebill = $hasNotified ? 1 : 0;

		$this->save();
	}


	/**
	 * @return bool
	 */
	public function notifyUserPendingRebill()
	{
		$customer = $this->customer;

		\Mail::send('emails.pending-rebill', [ 'rebillAt' => $this->getRebillAt() ], function (Message $message) use ($customer)
		{
			$message->to($customer->getEmail(), $customer->getName())
			        ->subject('Vi sender din næste pakke om 24 timer!');
		});

		$this->markHasNotified();

		return true;
	}
	
	public function isCustom()
	{
		return $this->is_custom == 1;
	}

	public function setIsCustom($isCustom = false)
	{
		$this->is_custom = $isCustom ? 1 : 0;
		$this->save();

		return true;
	}

	public function getPackage()
	{
		// todo
	}

}