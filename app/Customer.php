<?php namespace App;

use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Libraries\StripeLibrary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Date\Date;
use Stripe\Card;

/**
 * Class Customer
 * @package App
 *
 * @property integer id
 * @property integer user_id
 * @property integer plan_id
 * @property integer accept_newletters
 * @property mixed   birthday
 * @property string  gender
 * @property integer order_count
 * @property mixed   created_at
 * @property mixed   updated_at
 * @property mixed   deleted_at
 */
class Customer extends Model
{

	use SoftDeletes;

	private $customer_attributes = [];

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'customers';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable = [ 'user_id', 'plan_id' ];
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function plan()
	{
		return $this->hasOne('App\Plan', 'id', 'plan_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orders()
	{
		return $this->hasMany('App\Order', 'customer_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function customerAttributes()
	{
		return $this->hasMany('App\CustomerAttribute', 'customer_id', 'id');
	}

	/**
	 * @return Plan
	 */
	public function getPlan()
	{
		return $this->plan;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @return User
	 */
	public function getOrders()
	{
		return $this->orders;
	}

	public function isSubscribed()
	{
		return $this->getPlan()->isActive();
	}

	public function getSubscriptionPrice()
	{
		return $this->getPlan()->getTotal();
	}

	public function getStripeToken()
	{
		return $this->getPlan()->getStripeToken();
	}

	public function getCustomerAttribute($name, $default = '')
	{
		if ( isset($this->customer_attributes[ $name ]) )
		{
			return $this->customer_attributes[ $name ];
		}

		if ( !$attribute = $this->customerAttributes()->where('identifier', $name)->first() )
		{
			return $default;
		}

		$this->customer_attributes[ $name ] = $attribute->value;

		return $attribute->value;
	}

	public function getCustomerAttributes($onlyEditable = false)
	{
		$attributes = $this->customerAttributes();

		if ( $onlyEditable )
		{
			$attributes = $attributes->editable();
		}

		return $attributes->get();
	}

	public function getName()
	{
		return $this->getUser()->getName();
	}

	public function getEmail()
	{
		return $this->getUser()->getEmail();
	}

	public function getBirthday()
	{
		return $this->birthday;
	}

	public function getAge()
	{
		return Date::createFromFormat('Y-m-d', $this->getBirthday())->diffInYears();
	}

	public function getGender()
	{
		return $this->gender;
	}

	public function getOrderCount()
	{
		return $this->order_count;
	}

	public function rebill($amount = null)
	{
		if ( !$this->isSubscribed() )
		{
			return false;
		}

		// Todo check if should rebill?

		$lib = new StripeLibrary();

		return $lib->chargeCustomer($this, null, MoneyLibrary::toCents($amount) ?: $this->getSubscriptionPrice());
	}

	public function getStripeCustomer()
	{
		$lib = new StripeLibrary();

		return $lib->getCustomer($this);
	}

	/**
	 * @return Card
	 */
	public function getStripePaymentSource()
	{
		$stripeCustomer = $this->getStripeCustomer();

		if ( !$stripeCustomer || $stripeCustomer->sources->total_count <= 0 || !$source = $stripeCustomer->sources->data[0] )
		{
			$source = null;
		}

		return $source;
	}

	public function removePaymentOption()
	{
		$stripeCustomer = $this->getStripeCustomer();
		$stripeSource   = $this->getStripePaymentSource();

		if ( !$stripeSource )
		{
			return false;
		}

		if ( $stripeCustomer->sources->retrieve($stripeSource->id)->delete() )
		{
			\Cache::forget('stripe_customer_for_customer_' . $this->id);
		}

		return true;
	}

	public function getOrderById($id)
	{
		return $this->orders()->where('id', $id)->first();
	}

	public function makeOrder()
	{

	}

	public function charge()
	{

	}

	public function acceptNewsletters()
	{
		return $this->accept_newletters == 1;
	}

	public function scopeToday($query)
	{
		return $query->whereBetween('created_at', [
			Date::today()->setTime(0, 0, 0),
			Date::today()->setTime(23, 59, 59)
		]);
	}

}