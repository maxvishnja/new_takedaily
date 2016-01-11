<?php namespace App;

use App\Apricot\Libraries\StripeLibrary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Customer
 * @package App
 *
 * @property integer id
 * @property integer user_id
 * @property integer plan_id
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
		return $this->getPlan()->getTotalPrice();
	}

	public function getStripeToken()
	{
		return $this->getPlan()->getStripeToken();
	}

	public function getCustomerAttribute($name, $default = '')
	{
		if ( !$attribute = $this->customerAttributes()->where('identifier', $name)->first() )
		{
			return $default;
		}

		return $attribute->value;
	}

	public function getCustomerAttributes($onlyEditable = false)
	{
		$attributes = $this->customerAttributes();

		if( $onlyEditable )
		{
			$attributes = $attributes->editable();
		}

		return $attributes->get();
	}

	public function getName()
	{
		return $this->getUser()->getName();
	}

	public function getBirthday()
	{
		return $this->birthday;
	}

	public function getGender()
	{
		return $this->gender;
	}

	public function getOrderCount()
	{
		return $this->order_count;
	}

	public function rebill()
	{
		if ( !$this->isSubscribed() )
		{
			return false;
		}

		$lib = new StripeLibrary();
		return $lib->chargeCustomer($this, 'asdasd', 10);
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

}