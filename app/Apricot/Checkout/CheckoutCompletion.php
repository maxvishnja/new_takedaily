<?php namespace App\Apricot\Checkout;

use App\Apricot\Libraries\PillLibrary;
use App\Events\CustomerWasBilled;
use App\Giftcard;
use App\Setting;
use App\User;
use App\Vitamin;

class CheckoutCompletion
{
	private $checkout;

	/** @var User */
	public $user;

	private $userData;

	/** @var Giftcard */
	private $giftcardModel;

	function __construct( Checkout $checkout )
	{
		$this->checkout = $checkout;
	}

	/**
	 * @param $name
	 * @param $email
	 * @param $password
	 *
	 * @return $this
	 */
	public function createUser( $name, $email, $password )
	{
		if ( \Auth::check() )
		{
			$this->user = \Auth::user();
		}
		else
		{
			$user = User::create( [
				'name'     => ucwords( $name ),
				'email'    => $email,
				'password' => bcrypt( $password ),
				'type'     => 'user'
			] );

			$this->user = $user;
		}

		return $this;
	}

	/**
	 * @return Checkout
	 */
	public function getCheckout()
	{
		return $this->checkout;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	public function setCustomerAttributes( $attributes )
	{
		$this->getUser()->getCustomer()->setCustomerAttributes( $attributes );

		return $this;
	}

	public function setPlanPayment( $paymentCustomerToken, $paymentMethod )
	{
		$this->getUser()->getCustomer()->getPlan()->update( [
			'payment_customer_token' => $paymentCustomerToken,
			'payment_method'         => $paymentMethod
		] );

		return $this;
	}

	public function setUserData( $data )
	{
		$this->userData = $data;

		if ( $this->hasUserData() )
		{
			$this->updateCustomerWithUserData();
		}

		return $this;
	}

	public function getUserData()
	{
		return json_decode( $this->userData );
	}

	public function getGiftcard()
	{
		return $this->giftcardModel;
	}

	public function hasUserData()
	{
		return $this->getUserData() && is_object( $this->getUserData() ) && count( get_object_vars( $this->getUserData() ) ) > 0;
	}

	public function updateCustomerWithUserData()
	{
		$userData = $this->getUserData();

		if ( $userData )
		{
			$this->user->getCustomer()->update( [
				'birthday' => date( 'Y-m-d', strtotime( $userData->birthdate ) ),
				'gender'   => $userData->gender == 1 ? 'male' : 'female'
			] );

			$this->user->getCustomer()->updateUserdata( $userData );

		}

		return $this;
	}

	public function updateCustomerPlan()
	{
		if ( $this->getCheckout()->getProduct()->isSubscription() )
		{
			$this->getUser()->getCustomer()->getPlan()->update( [
				'price'                     => $this->getCheckout()->getSubscriptionPrice(),
				'price_shipping'            => Setting::getWithDefault( 'shipping_price', 0 ),
				'subscription_started_at'   => \Date::now(),
				'subscription_rebill_at'    => \Date::now()->addDays( 28 + 5 ), // todo remove +5 maybe
				'subscription_cancelled_at' => null
			] );

			if ( session( 'vitamins', false ) )
			{
				$vitamins = session( 'vitamins' );
				$this->getUser()->getCustomer()->getPlan()->update( [
					'is_custom' => 1
				] );
			}
			else
			{
				$combinations = $this->getUser()->getCustomer()->calculateCombinations();
				$vitamins     = [];

				foreach ( $combinations as $key => $combination )
				{
					$pill    = PillLibrary::getPill( $key, $combination );
					$vitamin = Vitamin::select( 'id' )->whereCode( $pill )->first();

					if ( $vitamin )
					{
						$vitamins[] = $vitamin->id;
					}
				}
			}

			$this->getUser()->getCustomer()->getPlan()->update( [
				'vitamins' => json_encode( $vitamins )
			] );
		}
		elseif(\Auth::guest())
		{
			$this->getUser()->getCustomer()->update( [
				'is_mailflowable' => 0
			] );

			$this->getUser()->getCustomer()->getPlan()->update( [
				'price'                     => 0,
				'price_shipping'            => Setting::getWithDefault( 'shipping_price', 0 ),
				'subscription_cancelled_at' => date( 'Y-m-d H:i:s' )
			] );
		}

		return $this;
	}

	public function handleProductActions()
	{
		// giftcard
		if ( str_contains( $this->getCheckout()->getProduct()->name, 'giftcard' ) )
		{
			$this->giftcardModel = Giftcard::create( [
				'token' => strtoupper( str_random() ),
				'worth' => $this->getCheckout()->getProduct()->price
			] );
		}

		return $this;
	}

	public function deductCouponUsage()
	{
		if ( $this->getCheckout()->getCoupon() )
		{
			$this->getCheckout()->getCoupon()->reduceUsagesLeft();
		}

		return $this;
	}

	public function markGiftcardUsed()
	{
		if ( $this->getCheckout()->getGiftcard() )
		{
			$this->getUser()->getCustomer()->setBalance( $this->getCheckout()->getGiftcard()->worth );
			$this->getCheckout()->getGiftcard()->markUsed();
		}

		return $this;
	}

	public function fireCustomerWasBilled( $chargeId )
	{
		\Event::fire( new CustomerWasBilled( $this->getUser()->getCustomer(),
			$this->getCheckout()->getTotal(),
			$chargeId,
			$this->getCheckout()->getProduct()->name,
			false,
			0,
			$this->getCheckout()->getCoupon()
		) );

		return $this;
	}

	public function queueEmail( $password )
	{
		$data = [
			'password'      => $password,
			'giftcard'      => $this->getCheckout()->getGiftcard() ? $this->getCheckout()->getGiftcard()->token : null,
			'description'   => trans( "products.{$this->getCheckout()->getProduct()->name}" ),
			'priceTotal'    => $this->getCheckout()->getTotal(),
			'priceSubtotal' => $this->getCheckout()->getSubTotal(),
			'priceTaxes'    => $this->getCheckout()->getTaxTotal()
		];

		$mailEmail = $this->getUser()->getEmail();
		$mailName  = $this->getUser()->getName();

		\Mail::queue( 'emails.order', $data, function ( $message ) use ( $mailEmail, $mailName )
		{
			$message->to( $mailEmail, $mailName );
			$message->subject( trans( 'checkout.mail.subject' ) );
		} );

		return $this;
	}

	public function flush()
	{
		if ( $this->getCheckout()->getProduct()->isSubscription() )
		{
			\Session::flush();
		}

		return $this;
	}

	public function initUpsell()
	{
		if ( $this->getCheckout()->getProduct()->isSubscription() )
		{
			$upsellToken = str_random();

			\Session::put( 'upsell_token', $upsellToken );
			\Session::put( 'product_name', $this->getCheckout()->getProduct()->name );
		}

		return $this;
	}

	public function loginUser()
	{
		if ( $this->getCheckout()->getProduct()->isSubscription() )
		{
			\Auth::login( $this->getUser(), true );
		}

		return $this;
	}
}