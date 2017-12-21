<?php namespace App\Apricot\Checkout;

use App\Apricot\Helpers\FacebookApiHelper;
use App\Customer;
use App\Events\CustomerWasBilled;
use App\Giftcard;
use App\MailStat;
use App\Nutritionist;
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
				'password' => $password,
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


	public function setSales ($id){


		$sale = Setting::find(17);
		$plan = User::find($id)->getCustomer()->getPlan();

		$plan->setDiscountType($sale->identifier);

		$plan->setCouponCount($sale->value);

		$plan->setReferalCount();


		return true;

	}

	public function updateCustomerWithUserData()
	{
		$userData = $this->getUserData();

		if ( $userData )
		{
			$this->user->getCustomer()->updateUserdata( $userData );

			$this->user->getCustomer()->update( [
				'birthday' => date( 'Y-m-d', strtotime( $userData->birthdate ) ),
				'gender'   => $userData->gender === (int) 1 ? 'male' : 'female'
			] );
		}

		return $this;
	}

	public function updateCustomerPlan($newvitamin=null)
	{
		if ( $this->getCheckout()->getProduct()->isSubscription() )
		{

			if(\Date::now(config('app.timezone')) < \Date::parse(date("Y-m-d 14:00:00"))){
				$newDate = \Date::now()->addDays( 28 );
			} else{
				$newDate = \Date::now()->addDays( 27 );
			}

            $dietologs = Nutritionist::where('locale', \App::getLocale())
                ->where('order', 0)
                ->where('active', 1)
                ->get();

            $dietologs_all_active = Nutritionist::where('locale', \App::getLocale())
                ->where('active', 1)
                ->get();

            if(count($dietologs_all_active)>0) {

                if ($dietologs->isEmpty() and count($dietologs_all_active) > 0) {
                    $dietologs = Nutritionist::where('locale', \App::getLocale())
                        ->where('active', 1)
                        ->get();
                    foreach ($dietologs as $dietolog) {
                        $dietolog->order = 0;
                        $dietolog->save();
                    }
                    $dietologs = Nutritionist::where('locale', \App::getLocale())
                        ->where('order', 0)
                        ->where('active', 1)
                        ->get();
                }
                $dietolog_ids = [];

                if (count($dietologs) == 1 and count($dietologs_all_active) > 1) {

                    $dietolog_ids = $dietologs[0]['id'];
                    $dietolog_order = Nutritionist::where('id', $dietolog_ids)->first();
                    $dietolog_order->order = 1;
                    $dietolog_order->save();
                } elseif (count($dietologs) == 0) {
                    $dietolog_ids = 0;
                } else {
                    /** @var Nutritionist $dietolog */
                    foreach ($dietologs as $dietolog) {
                        if ($dietolog->order == 0) {
                            $dietolog_ids = $dietolog->id;
                        }
                    }
                    $dietolog_order = Nutritionist::where('id', $dietolog_ids)->first();
                    $dietolog_order->order = 1;
                    $dietolog_order->save();
                }

            } else{
                $dietolog_ids = '';
            }
			$this->getUser()->getCustomer()->getPlan()->update( [
				'price'                     => $this->getCheckout()->getSubscriptionPrice(),
				'price_shipping'            => Setting::getWithDefault( 'shipping_price', 0 ),
				'subscription_started_at'   => \Date::now(),
				'currency'                  => trans( 'general.currency' ),
				'subscription_rebill_at'    => $newDate,
				'subscription_cancelled_at' => null,
                'nutritionist_id'           => $dietolog_ids,
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

				if($newvitamin){
					$combinations[count($combinations)-1] = $newvitamin;
				}
				$vitamins     = [];

				foreach ( $combinations as $pill )
				{
					$vitamin = Vitamin::select( 'id' )->whereCode( $pill )->first();

					if ( $vitamin )
					{
						$vitamins[] = $vitamin->id;
					}
				}
			}

            if (count($vitamins) == 0){

                $vitamins = ['2','5','13'];
            }


			$this->getUser()->getCustomer()->getPlan()->update( [
				'vitamins' => json_encode( $vitamins )
			] );
		}
		elseif ( \Auth::guest() )
		{
			$this->getUser()->getCustomer()->update( [
				'is_mailflowable' => 0
			] );

			$this->getUser()->getCustomer()->getPlan()->update( [
				'price'                     => 0,
				'currency'                  => trans( 'general.currency' ),
				'price_shipping'            => Setting::getWithDefault( 'shipping_price', 0 ),
				'subscription_cancelled_at' => date( 'Y-m-d H:i:s' )
			] );
		}

		return $this;
	}


	public function updatePriceDiscount (){

        $this->getUser()->getCustomer()->getPlan()->update( [
            'price_discount'                     => $this->getCheckout()->getSubscriptionPriceDiscount(),

        ] );

        return $this;
    }


	public function handleProductActions()
	{
		// giftcard
		if ( str_contains( $this->getCheckout()->getProduct()->name, 'giftcard' ) )
		{
			$this->giftcardModel = Giftcard::create( [
				'token'    => strtoupper( str_random() ),
				'worth'    => $this->getCheckout()->getTotal(),
				'currency' => trans( 'general.currency' )
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
			$this->getUser()->getCustomer()->setBalance( $this->getCheckout()->getGiftcard()->worth - $this->getCheckout()->getTotalBeforeGiftcard() );
			$this->getCheckout()->getGiftcard()->markUsed();
		}

		return $this;
	}

	public function fireCustomerWasBilled( $chargeId, $gift, $order_plan )
	{
		\Event::fire( new CustomerWasBilled( $this->getUser()->getCustomer()->id,
			$this->getCheckout()->getTotal(),
			$chargeId,
			$this->getCheckout()->getProduct()->name,
			false,
			0,
			$this->getCheckout()->getCoupon(),
			$gift,
			$order_plan,
			false
		) );

		return $this;
	}

	public function queueEmail( $password, $name = '' )
	{
		$mailEmail = $this->getUser()->getEmail();
		$mailName  = $this->getUser()->getName();
		$locale    = $this->getUser()->getCustomer()->getLocale();

		$data = [
			'password'      => $password,
			'giftcard'      => $this->getCheckout()->getGiftcard() ? $this->getCheckout()->getGiftcard()->token : null,
			'description'   => trans( "products.{$this->getCheckout()->getProduct()->name}" ),
			'priceTotal'    => $this->getCheckout()->getTotal(),
			'priceSubtotal' => $this->getCheckout()->getSubTotal(),
			'priceTaxes'    => $this->getCheckout()->getTaxTotal(),
			'name'          => $this->getUser()->getCustomer()->getFirstname(),
			'locale'        => $locale
		];


		if($data['locale'] == 'nl') {
			$fromEmail = 'info@takedaily.nl';
		} else{
			$fromEmail = 'info@takedaily.dk';
		}

        \App::setLocale( $locale );

        $mailCount = new MailStat();

		if ($this->getCheckout()->getProduct()->name != 'subscription'){

            $mailCount->setMail(2);
        } else {

            $mailCount->setMail(1);
        }


        $fbApi = new FacebookApiHelper();

        $bday = '';

        if($this->getUser()->getCustomer()->getBirthday()){
            $bday = \Date::createFromFormat('Y-m-d', $this->getUser()->getCustomer()->getBirthday())->format('Y');
        }


        if($locale == "nl"){
            $dataFb['id'] = config('services.fbApi.nl_active');
            $locale = 'NL';
        } else {
            $dataFb['id'] = config('services.fbApi.dk_active');
            $locale = 'DK';
        }


        $dataFb['data_users'] = [
            $this->getUser()->getCustomer()->getFirstname(),
            $this->getUser()->getCustomer()->getLastName(),
            $this->getUser()->getCustomer()->getPhone(),
            $this->getUser()->getCustomer()->getEmail(),
            $bday,
            $this->getUser()->getCustomer()->getGender(),
            $locale
        ];

        try{

            $fbApi->addToAudience($dataFb);

        } catch (\Exception $exception) {

            \Log::error("Error in add to FB new user  : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

        }



		\Mail::queue( 'emails.order', $data, function ( $message ) use ( $mailEmail, $mailName, $locale, $fromEmail )
		{

			$message->from( $fromEmail, 'TakeDaily' );
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
		if ( $this->getCheckout()->getProduct()->isSubscription() && \Auth::guest() )
		{
			\Auth::login( $this->getUser(), true );
		}

		return $this;
	}
}