<?php namespace App;

use App\Apricot\Libraries\CombinationLibrary;
use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Libraries\StripeLibrary;
use App\Events\CustomerWasBilled;
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

	protected $fillable = [ 'user_id', 'plan_id', 'balance' ];
	
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

	public function cancelSubscription($force = false)
	{
		if ( ( !$this->getPlan()->isCancelable() && !$force) || $this->getPlan()->isCancelled() )
		{
			return false;
		}

		return $this->getPlan()->cancel();
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
		if ( !$attribute = $this->customerAttributes->where('identifier', $name)->first() )
		{
			return $default;
		}

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

	public function hasBirthday()
	{
		return !is_null($this->birthday);
	}

	public function getBirthday()
	{
		return $this->birthday;
	}

	public function getAge()
	{
		if ( is_null($this->getBirthday()) )
		{
			return false;
		}

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

		return $this->charge(MoneyLibrary::toCents($amount) ? : $this->getSubscriptionPrice());
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

	public function setCustomerAttribute($identifier, $value)
	{
		$attribute = $this->customerAttributes()->where('identifier', $identifier)->first();

		if ( !$attribute )
		{
			$this->customerAttributes()->create([
				'identifier' => $identifier,
				'value'      => $value ? : ''
			]);

			return true;
		}

		return $attribute->update([ 'value' => $value ? : '' ]);
	}

	public function setCustomerAttributes($attributes = [ ])
	{
		foreach ( $attributes as $identifier => $value )
		{
			$this->setCustomerAttribute($identifier, $value);
		}

		return true;
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

	public function makeOrder($amount = 100, $stripeChargeToken = null, $shipping = null, $product_name = 'subscription', $usedBalance = false, $balanceAmount = 0, $coupon = null)
	{
		$shipping = $shipping ? : $this->getPlan()->getShippingPrice();
		$taxes    = $amount * 0.20; // todo dynamic

		$order = $this->orders()->create([
			'reference'           => (str_random(8) . '-' . str_random(2) . '-' . str_pad($this->getOrders()->count() + 1, 4, '0', STR_PAD_LEFT)),
			'stripe_charge_token' => $stripeChargeToken ? : '',
			'state'               => ($stripeChargeToken ? 'paid' : 'new'),
			'total'               => $amount,
			'total_shipping'      => $shipping,
			'sub_total'           => $amount - $shipping - $taxes,
			'total_taxes'         => $taxes,
			'shipping_name'       => $this->getName(),
			'shipping_street'     => $this->getCustomerAttribute('address_line1'),
			'shipping_city'       => $this->getCustomerAttribute('address_city'),
			'shipping_country'    => $this->getCustomerAttribute('address_country'),
			'shipping_zipcode'    => $this->getCustomerAttribute('address_postal'),
			'shipping_company'    => $this->getCustomerAttribute('company')
		]);

		$product = Product::where('name', $product_name)->first();

		$order->lines()->create([
			'description'  => $product_name,
			'amount'       => $product->price * 0.8,
			'tax_amount'   => $product->price * 0.2,
			'total_amount' => $product->price
		]);

		if ( $usedBalance )
		{
			$order->lines()->create([
				'description'  => 'balance',
				'amount'       => $balanceAmount * 0.8,
				'tax_amount'   => 0,
				'total_amount' => $balanceAmount * 1.25
			]);
		}

		if ( $shipping > 0 )
		{
			$order->lines()->create([
				'description'  => 'shipping',
				'amount'       => $shipping,
				'tax_amount'   => 0,
				'total_amount' => $shipping
			]);
		}

		if ( $coupon )
		{
			$couponAmount = 0;

			if ( $coupon->discount_type == 'percentage' )
			{
				$couponAmount = ($product->price * 0.8) * ($coupon->discount / 100);
			}
			elseif ( $coupon->discount_type == 'amount' )
			{
				$couponAmount = $coupon->discount;
			}

			$order->lines()->create([
				'description'  => 'coupon',
				'amount'       => $couponAmount * -1,
				'tax_amount'   => 0,
				'total_amount' => $couponAmount * 1.25 * -1
			]);
		}

		return $order;
	}

	public function setBalance($amount)
	{
		$this->balance = $amount;
		$this->save();
	}

	public function deductBalance($amount)
	{
		$this->setBalance($this->balance -= $amount);
	}

	public function charge($amount, $makeOrder = true, $product = 'subscription', $coupon)
	{
		$lib = new StripeLibrary();

		$chargeId    = '';
		$usedBalance = false;
		$prevAmount  = 0;

		if ( $this->balance > 0 )
		{
			$prevAmount = ($this->balance > $amount ? $amount : $this->balance);
			$amount -= ($this->balance > $amount ? $amount : $this->balance);
			$this->deductBalance($this->balance > $prevAmount ? $prevAmount : $this->balance);
			$chargeId    = 'balance';
			$usedBalance = true;
		}

		if ( $amount > 0 )
		{
			$charge = $lib->chargeCustomer($this, null, $amount);

			if ( !$charge )
			{
				return false;
			}

			$chargeId = $charge->id;
		}
		else
		{
			if( $chargeId == '')
			{
				$chargeId = 'free';
			}
		}

		if ( $makeOrder )
		{
			\Event::fire(new CustomerWasBilled($this, $amount, $chargeId, $product, $usedBalance, $prevAmount * - 1, $coupon));
		}

		return true;
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

	public function getCombinations()
	{
		$combinationLibrary = new CombinationLibrary();

		$attributes = $this->customerAttributes()->where('identifier', 'LIKE', 'user_data.%')->get();

		$data = new \stdClass();

		foreach ( $attributes as $attribute )
		{
			$attributePoints = explode('.', $attribute->identifier);

			if ( count($attributePoints) > 2 )
			{
				if ( !isset($data->{$attributePoints[1]}) )
				{
					$data->{$attributePoints[1]} = new \stdClass();
				}

				$data->{$attributePoints[1]}->{$attributePoints[2]} = $attribute->value;
			}
			else
			{
				$data->{$attributePoints[1]} = $attribute->value;
			}
		}

		$combinationLibrary->generateResult($data);

		return $combinationLibrary->getResult();
	}

	/**
	 * @return \PDF
	 */
	public function generateLabel()
	{
		return \PDF::loadView('pdf.label', [ 'customer' => $this ])->setPaper([ 0, 0, 570, 262 ])->setOrientation('landscape');
	}

	public function scopeRebillable($query)
	{
		return $query->join('plans', 'plans.id', '=', 'customers.plan_id')
					 ->whereNull('plans.deleted_at')
					 ->whereNull('plans.subscription_cancelled_at')
					 ->whereNotNull('plans.subscription_rebill_at')
					 ->where('plans.subscription_rebill_at', '<=', Date::now());
	}

}