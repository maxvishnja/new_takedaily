<?php namespace App;

use App\Apricot\Libraries\CombinationLibrary;
use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Libraries\PaymentDelegator;
use App\Apricot\Libraries\PaymentHandler;
use App\Apricot\Libraries\StripeLibrary;
use App\Apricot\Libraries\TaxLibrary;
use App\Events\CustomerWasBilled;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Date\Date;

/**
 * Class Customer
 *
 * @package App
 * @property integer                                                                $id
 * @property integer                                                                $user_id
 * @property integer                                                                $plan_id
 * @property string                                                                 $birthday
 * @property string                                                                 $gender
 * @property boolean                                                                $accept_newletters
 * @property integer                                                                $order_count
 * @property integer                                                                $balance
 * @property \Carbon\Carbon                                                         $created_at
 * @property \Carbon\Carbon                                                         $updated_at
 * @property string                                                                 $deleted_at
 * @property-read \App\Plan                                                         $plan
 * @property-read \App\User                                                         $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[]             $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CustomerAttribute[] $customerAttributes
 * @property mixed                                                                  $customer
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereAcceptNewletters($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereOrderCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer today()
 * @method static \Illuminate\Database\Query\Builder|\App\Customer rebillable()
 * @mixin \Eloquent
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
	protected $hidden = [];

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
		if ( (!$this->getPlan()->isCancelable() && !$force) || $this->getPlan()->isCancelled() )
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
	{ // todo move to handler
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
		return !is_null($this->getBirthday());
	}

	public function getBirthday()
	{
		return $this->getCustomerAttribute('user_data.birthdate', $this->birthday);
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
		return $this->getCustomerAttribute('user_data.gender', $this->gender);
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

		if ( !$this->charge(MoneyLibrary::toCents($amount) ?: $this->getSubscriptionPrice(), true, 'subscription', '') )
		{
			return false;
		}

		$this->getPlan()->rebilled();

		return true;
	}

	public function getStripeCustomer() // todo convert to paymentHandler
	{
		$lib = new StripeLibrary();

		return $lib->getCustomer($this);
	}

	public function setCustomerAttribute($identifier, $value)
	{
		$attribute = $this->customerAttributes()->where('identifier', $identifier)->first();

		if ( !$attribute )
		{
			$this->customerAttributes()->create([
				'identifier' => $identifier,
				'value'      => $value ?: ''
			]);

			return true;
		}

		return $attribute->update([ 'value' => $value ?: '' ]);
	}

	public function setCustomerAttributes($attributes = [])
	{
		foreach ( $attributes as $identifier => $value )
		{
			$this->setCustomerAttribute($identifier, $value);
		}

		return true;
	}

	public function removePaymentOption()
	{
		$paymentMethod  = PaymentDelegator::getMethod($this->getPlan()->getPaymentMethod());
		$paymentHandler = new PaymentHandler($paymentMethod);

		$deleteResponse = $paymentHandler->deleteMethodFor($this->getPlan()->getPaymentCustomerToken());

		if ( $deleteResponse['purge_plan'] )
		{
			$this->getPlan()->update([ 'payment_customer_token' => '', 'payment_method' => '' ]);
		}

		return true;
	}

	public function getOrderById($id)
	{
		return $this->orders()->where('id', $id)->first();
	}

	public function makeOrder($amount = 100, $chargeToken = null, $shipping = null, $product_name = 'subscription', $usedBalance = false, $balanceAmount = 0, $coupon = null)
	{
		$taxing = new TaxLibrary($this->getCustomerAttribute('address_country'));

		$shipping = $shipping ?: $this->getPlan()->getShippingPrice();
		$taxes    = $amount * $taxing->rate();

		$order = $this->orders()->create([
			'reference'        => (str_random(8) . '-' . str_random(2) . '-' . str_pad($this->getOrders()
			                                                                                ->count() + 1, 4, '0', STR_PAD_LEFT)),
			'payment_token'    => $chargeToken ?: '',
			'payment_method'   => $this->getPlan()->getPaymentMethod(),
			'state'            => ($chargeToken ? 'paid' : 'new'),
			'total'            => $amount,
			'total_shipping'   => $shipping,
			'sub_total'        => $amount - $shipping - $taxes,
			'total_taxes'      => $taxes,
			'shipping_name'    => $this->getName(),
			'shipping_street'  => $this->getCustomerAttribute('address_line1'),
			'shipping_city'    => $this->getCustomerAttribute('address_city'),
			'shipping_country' => $this->getCustomerAttribute('address_country'),
			'shipping_zipcode' => $this->getCustomerAttribute('address_postal'),
			'shipping_company' => $this->getCustomerAttribute('company')
		]);

		$product = Product::where('name', $product_name)->first();

		$order->lines()->create([
			'description'  => $product_name,
			'amount'       => $product->price * $taxing->reversedRate(),
			'tax_amount'   => $product->price * $taxing->rate(),
			'total_amount' => $product->price
		]);

		if ( $usedBalance )
		{
			$order->lines()->create([
				'description'  => 'balance',
				'amount'       => 0,
				'tax_amount'   => 0,
				'total_amount' => $balanceAmount
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
				$couponAmount = $product->price * ($coupon->discount / 100);
			}
			elseif ( $coupon->discount_type == 'amount' )
			{
				$couponAmount = $coupon->discount;
			}

			$order->lines()->create([
				'description'  => 'coupon',
				'amount'       => 0,
				'tax_amount'   => 0,
				'total_amount' => $couponAmount * -1
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

	public function addBalance($amount)
	{
		$this->setBalance($this->balance += $amount);
	}

	public function charge($amount, $makeOrder = true, $product = 'subscription', $coupon)
	{
		/** @var PaymentHandler $paymentHandler */
		$paymentHandler = new PaymentHandler(PaymentDelegator::getMethod($this->getPlan()->getPaymentMethod()));

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
			$charge = $paymentHandler->makeRebill($amount, $this->getPlan()->getPaymentCustomer());

			if ( !$charge )
			{
				return false;
			}

			$chargeId = $charge->id;
		}
		else
		{
			if ( $chargeId == '' )
			{
				$chargeId = 'free';
			}
		}

		if ( $makeOrder )
		{
			\Event::fire(new CustomerWasBilled($this, $amount, $chargeId, $product, $usedBalance, $prevAmount * -1, $coupon));
		}

		return true;
	}

	public function scopeToday($query)
	{
		return $query->whereBetween('created_at', [
			Date::today()->setTime(0, 0, 0),
			Date::today()->setTime(23, 59, 59)
		]);
	}

	public function hasNewRecommendations()
	{
		$alphabet        = range('a', 'c');
		$combinations    = $this->calculateCombinations();
		$newVitamins     = [];
		$currentVitamins = [];
		$isSimilar       = true;

		if(count($combinations) == 0)
		{
			return false;
		}

		foreach ( $this->getVitaminModels() as $vitaminModel )
		{
			$currentVitamins[] = substr($vitaminModel->code, 1, 1);
		}

		foreach ( $combinations as $index => $combination )
		{
			if ( $index == 'one' )
			{
				$combination = $alphabet[ $combination - 1 ];
			}

			$newVitamins[] = strtolower($combination);
		}

		if ( count($newVitamins) != count($currentVitamins) )
		{
			$isSimilar = false;

			return !$isSimilar;
		}

		foreach ( $currentVitamins as $index => $currentVitamin )
		{
			if ( $currentVitamin != $newVitamins[ $index ] )
			{
				$isSimilar = false;
				continue;
			}
		}

		return !$isSimilar;
	}


	public function calculateCombinations()
	{
		if( $this->plan->isCustom() )
		{
			return [];
		}

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

	public function getVitamins()
	{
		return $this->getPlan()->vitamins;
	}

	public function setVitamins(array $vitamins)
	{
		return $this->getPlan()->update([ 'vitamins' => json_encode($vitamins) ]);
	}

	public function getVitaminModels()
	{
		$vitamins = json_decode($this->getVitamins());

		return Vitamin::whereIn('id', $vitamins)->get();
	}

	public function loadLabel()
	{
		return view('pdf.label', [ 'customer' => $this ]);
	}

	public function loadSticker()
	{
		return view('pdf.sticker', [ 'customer' => $this ]);
	}

	/**
	 * @return \PDF
	 */
	public function generateLabel()
	{
		return \PDF::loadView('pdf.label', [ 'customer' => $this ])
		           ->setPaper([ 0, 0, 570, 262 ])
		           ->setOrientation('landscape');
	}

	/**
	 * @return \PDF
	 */
	public function generateSticker()
	{
		return \PDF::loadView('pdf.sticker', [ 'customer' => $this ])
		           ->setPaper([ 0, 0, 531, 723 ])
		           ->setOrientation('portrait');
	}

	public function scopeRebillable($query)
	{
		return $query->join('plans', 'plans.id', '=', 'customers.plan_id')
		             ->whereNull('plans.deleted_at')
		             ->whereNull('plans.subscription_cancelled_at')
		             ->whereNotNull('plans.subscription_rebill_at')
		             ->where('plans.subscription_rebill_at', '<=', Date::now());
	}

	public function getPaymentMethods()
	{
		$plan = $this->getPlan();

		if ( $plan->getPaymentMethod() == '' )
		{
			return [
				'methods' => [],
				'type'    => ''
			];
		}

		$paymentMethod  = PaymentDelegator::getMethod($plan->getPaymentMethod());
		$paymentHandler = new PaymentHandler($paymentMethod);

		return [
			'type'    => $plan->getPaymentMethod(),
			'methods' => $paymentHandler->getCustomerMethods($plan->getPaymentCustomerToken())
		];
	}

}