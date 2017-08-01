<?php namespace App;

use App\Apricot\Libraries\PaymentDelegator;
use App\Apricot\Libraries\PaymentHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePaymentCustomerToken( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePaymentMethod( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePrice( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePriceShipping( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereVitamins( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionStartedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionCancelledAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionSnoozedUntil( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionRebillAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereDeletedAt( $value )
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
		'coupon_free',
		'last_coupon',
		'subscription_started_at',
		'subscription_cancelled_at',
		'subscription_snoozed_until',
		'subscription_rebill_at',
		'old_rebill_at',
		'unsubscribe_reason',
		'currency',
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
		return $this->belongsTo( 'App\Customer', 'id', 'plan_id' );
	}

	public function isActive()
	{
		return ! $this->isCancelled() && ! is_null( $this->getRebillAt() );
	}

	public function isCancelled()
	{
		return ! is_null( $this->getSubscriptionCancelledAt() );
	}

	public function hasFishoil()
	{
		$vitamins = json_decode( $this->vitamins );

		if ( is_null( $vitamins ) )
		{
			return false;
		}

		return Vitamin::whereIn( 'id', $vitamins )->where('code', '3e')->limit(1)->count() === 1; // todo unhardcode the 3e code
	}


	public function getVitamiPlan (){

		$vitamins = json_decode( $this->vitamins );

		if ( is_null( $vitamins ) )
		{
			return false;
		}

		foreach($vitamins as $vitamin){
			$allvitamins[] = Vitamin::find($vitamin);
		}
		if(isset($allvitamins)){
			return $allvitamins;
		} else {
			return false;
		}

	}




	public function getVitamins (){

		$vitamins = json_decode( $this->vitamins );

		if ( is_null( $vitamins ) )
		{
			return false;
		}
		return $vitamins;
	}

	public function getCouponCount(){

		return $this->coupon_free;
	}


	public function setCouponCount($count){

		$this->coupon_free = $count;
		$this->save();
	}

	public function setDiscountType($type)
	{
		$this->discount_type = $type;
		$this->save();
	}


	public function setLastCoupon($code){

		$this->last_coupon = $code;
		$this->save();
	}

	public function clearDiscount(){

		$this->coupon_free = 0;
		$this->discount_type = '';
		$this->save();
	}

	public function getLastCoupon(){

		return $this->last_coupon;

	}


	public function getDiscountType(){

		return $this->discount_type;

	}

	public function hasChiaoil()
	{
		$vitamins = json_decode( $this->vitamins );

		if ( is_null( $vitamins ) )
		{
			return false;
		}

		return Vitamin::whereIn( 'id', $vitamins )->where('code', '3g')->limit(1)->count() === 1; // todo unhardcode the 3e code
	}

	public function isSnoozed()
	{
		if ( ! is_null( $this->getSubscriptionSnoozedUntil() ) && Date::createFromFormat( 'Y-m-d H:i:s', $this->getSubscriptionSnoozedUntil() )
		                                                              ->diffInSeconds() <= 0
		)
		{
			$this->subscription_snoozed_until = null;
			$this->save();
		}

		return ! is_null( $this->getSubscriptionSnoozedUntil() );
	}

	public function snooze( $days )
	{
		$newDate = Date::parse($days."14:10:00");

		$this->subscription_snoozed_until = $newDate;
		$this->subscription_rebill_at     = $newDate;
		$this->save();

		return true;
	}

	public function moveRebill( $days = 1 )
	{
		$this->subscription_rebill_at = Date::createFromFormat( 'Y-m-d H:i:s', $this->getRebillAt() )->addWeekday( $days );
		$this->save();

		return true;
	}


	public function setNewRebill( $date )
	{
		if(!empty($date)){
			$this->subscription_rebill_at = Date::createFromFormat( 'Y-m-d', $date );
			$this->save();
		}
		return true;
	}

	public function isSnoozeable()
	{

		return $this->isActive()
		       //&& ! $this->isSnoozed()
		       && Date::createFromFormat( 'Y-m-d H:i:s', $this->created_at )->diffInDays() >= 1
		       && Date::createFromFormat( 'Y-m-d H:i:s', $this->getRebillAt() )->diffInDays() >= 1;
	}

	public function isCancelable()
	{
		return Date::createFromFormat( 'Y-m-d H:i:s', $this->created_at )->diffInDays() >= 1
		       && Date::createFromFormat( 'Y-m-d H:i:s', $this->getRebillAt() )->diffInDays() >= 1
		       && Date::createFromFormat( 'Y-m-d H:i:s', $this->getRebillAt() ) > Date::now();
	}

	public function cancel($reason = '')
	{
		$this->subscription_snoozed_until = null;
		$this->subscription_cancelled_at  = Date::now();
		$this->old_rebill_at  = $this->subscription_rebill_at;
		$this->subscription_rebill_at     = null;
		$this->unsubscribe_reason     = $reason;
		$this->save();

		$customer = $this->customer;

		\App::setLocale($customer->getLocale());

		if($customer->getLocale()== 'nl') {
			$fromEmail = 'info@takedaily.nl';
		} else{
			$fromEmail = 'info@takedaily.dk';
		}

		$mailEmail = $customer->getUser()->getEmail();
		$mailName = $customer->getUser()->getName();

		\Mail::queue( 'emails.cancel', [ 'locale' => $customer->getLocale(), 'reason' => $reason, 'name' => $customer->getFirstname()], function ( Message $message ) use ( $mailEmail, $mailName, $customer, $fromEmail )
		{
			$message->from($fromEmail, 'TakeDaily')
				->to($mailEmail, $mailName)
				->subject(trans('mails.cancel.subject') );
		} );




		return true;
	}

	public function start()
	{
		$this->subscription_snoozed_until = null;
		$this->subscription_cancelled_at  = null;
		$this->subscription_rebill_at     = Date::now()->addDays( 28 );
		//$this->subscription_rebill_at     = Date::now()->addDays( 28 );
		$this->save();

		return true;
	}

	public function rebilled()
	{
		$this->subscription_rebill_at = Date::now()->addDays( 28 );
		$this->subscription_snoozed_until = null;
		$this->save();

		$this->markHasNotified( false );

		return true;
	}


	public function setSnoozingDate(){

		$this->snoozing_at = Date::now();
		$this->save();

		return true;
	}




	public function startFromToday()
	{
		$this->subscription_snoozed_until = null;
		$this->subscription_cancelled_at  = null;
		$this->unsubscribe_reason = '';
		if($this->old_rebill_at > Date::now()){
			$this->subscription_rebill_at  = $this->old_rebill_at;
		} else {
			$this->subscription_rebill_at  = Date::now();
		}
		$this->old_rebill_at = null;
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

	public function getReasonCancel()
	{
		return $this->unsubscribe_reason;
	}


	public function getSubscriptionStartedAt()
	{
		return $this->subscription_started_at;
	}

	public function getRebillAt()
	{
		return $this->subscription_rebill_at;
	}

	public function getNextDelivery()
	{
		return (new Date($this->getRebillAt()))->addDays(5)->format('Y-m-d');
	}

	public function getStartNextDeliveryNl()
	{
		return (new Date($this->getRebillAt()))->addWeekdays(2)->format('Y-m-d');
	}

	public function getEndNextDeliveryNl()
	{
		return (new Date($this->getRebillAt()))->addWeekdays(5)->format('Y-m-d');
	}

	public function getStartNextDeliveryDk()
	{
		return (new Date($this->getRebillAt()))->addWeekdays(3)->format('Y-m-d');
	}

	public function getEndNextDeliveryDk()
	{
		return (new Date($this->getRebillAt()))->addWeekdays(7)->format('Y-m-d');
	}

	public function getTotal()
	{
		return $this->getPrice() + $this->getShippingPrice();
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function setPrice( $newamount )
	{
		$this->price = $newamount;
		$this->save();

		return true;
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

		$paymentMethod = new PaymentHandler( PaymentDelegator::getMethod( $this->getPaymentMethod() ) );

		return $paymentMethod->getCustomer( $customerToken );
	}

	public function getPaymentHandler()
	{
		$paymentMethod = new PaymentHandler( PaymentDelegator::getMethod( $this->getPaymentMethod() ) );

		return $paymentMethod;
	}

	/**
	 * @param Builder $query
	 *
	 * @return mixed
	 */
	public function scopeRebillPending( $query )
	{
		return $query->where( 'subscription_rebill_at', '<=', Date::now()->addDays( 3 ) )
		             ->where( function ( $where )
		             {
			             $where->whereNull( 'subscription_snoozed_until' )
			                   ->orWhere( 'subscription_snoozed_until', '<=', Date::now()->addDays( 3 ) );
		             } )
		             ->whereNull( 'subscription_cancelled_at' );

	}

	/**
	 * @param Builder $query
	 *
	 * @return mixed
	 */
	public function scopeNotNotifiedPending( $query )
	{
		return $query->where( 'has_notified_pending_rebill', 0 );
	}

	private function markHasNotified( $hasNotified = true )
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
		\App::setLocale($customer->getLocale());
		if($customer->getLocale()== 'nl') {
			$fromEmail = 'info@takedaily.nl';
			$url = "https://takedaily.nl/account/transactions?already_open=1";
		} else{
			$fromEmail = 'info@takedaily.dk';
			$url = "https://takedaily.dk/account/transactions?already_open=1";
		}

		$image = 'https://takedaily.nl/checksnooz/'.base64_encode($customer->getEmail()).'/'.  rand(1, 999).'/email.png';


		\Mail::queue( 'emails.pending-rebill', [ 'locale' => $customer->getLocale(), 'rebillAt' => $this->getRebillAt(), 'name' => $customer->getFirstname(), 'link' => $url, 'image' => $image ], function ( Message $message ) use ( $customer, $fromEmail )
		{
			\Log::info("Message send to ".$customer->getName()."(id ".$customer->id.", mail ".$customer->getEmail().")");

			$message->from($fromEmail, 'TakeDaily')
					->to( $customer->getEmail(), $customer->getName() )
			        ->subject( trans('mails.pending.subject') );
		} );

		$snoozing = new Snoozing();
		$snoozing->customer_id = $customer->id;
		$snoozing->email = $customer->getEmail();
		$snoozing->save();
		$this->setSnoozingDate();
		$this->markHasNotified();

		return true;
	}

	public function isCustom()
	{
		return $this->is_custom == 1;
	}

	public function setIsCustom( $isCustom = false )
	{
		$this->is_custom = $isCustom ? 1 : 0;
		$this->save();

		return true;
	}

	public function getPackage()
	{
		// todo
	}

	public function setNullSnooze()
	{
		$this->subscription_snoozed_until = null;
		$this->save();

		return true;
	}

}