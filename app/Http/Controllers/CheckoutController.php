<?php namespace App\Http\Controllers;

use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Libraries\PaymentDelegator;
use App\Apricot\Libraries\PaymentHandler;
use App\Apricot\Libraries\TaxLibrary;
use App\Apricot\Repositories\CouponRepository;
use App\Events\CustomerWasBilled;
use App\Giftcard;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;

class CheckoutController extends Controller
{

	function __construct()
	{

	}

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	function getCheckout(Request $request)
	{
		\Session::set('product_name', $request->get('product_name', \Session::get('product_name', 'subscription')));

		if ( \Session::get('product_name') == 'subscription' && !\Session::has('user_data') )
		{
			return \Redirect::to('/flow')->withErrors([ trans('checkout.messages.vitamins-not-selected') ]);
		}

		$giftcard = null;

		if ( \Session::has('giftcard_id') && \Session::has('giftcard_token') && \Session::get('product_name') == 'subscription' )
		{
			$giftcard = Giftcard::where('id', \Session::get('giftcard_id'))
								->where('token', \Session::get('giftcard_token'))
								->where('is_used', 0)
								->first();
		}

		return view('checkout.index', [
			'user_data' => \Session::get('user_data'),
			'product'   => Product::where('name', \Session::get('product_name', 'subscription'))->first(),
			'giftcard'  => $giftcard
		]);
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	function getTaxRate(Request $request)
	{
		$zone = new TaxLibrary($request->get('zone'));

		return \Response::json([ 'rate' => $zone->rate() ]);
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	function postCheckout(Request $request)
	{
		$this->validate($request, [
			'email'           => 'email|required|unique:users,email',
			'name'            => 'required',
			'address_street'  => 'required',
			'address_zipcode' => 'required',
			'address_city'    => 'required',
			'address_country' => 'required',
			'payment_method'  => 'required',
			'stripeToken'     => 'required_if:payment_method,stripe',
			'user_data'       => 'required'
		], [
			'email.unique' => trans('checkout.messages.email-taken'),
			'email.email'  => trans('checkout.messages.email-invalid')
		]);

		// Payment provider
		$paymentMethod  = PaymentDelegator::getMethod($request->get('payment_method'));
		$paymentHandler = new PaymentHandler($paymentMethod);

		// Coupon Repo
		$couponRepository = new CouponRepository();

		// Info
		$coupon  = $couponRepository->findByCoupon($request->get('coupon', ''));
		$product = Product::where('name', $request->get('product_name', 'subscription'))->first();

		// Price
		$orderPrice        = MoneyLibrary::toMoneyFormat($product->price);
		$subscriptionPrice = $product->is_subscription == 1 ? MoneyLibrary::toMoneyFormat($product->price) : 0;

		// Coupon
		if ( $coupon )
		{
			if ( $coupon->discount_type == 'percentage' )
			{
				$orderPrice -= $orderPrice * ($coupon->discount / 100);
			}
			elseif ( $coupon->discount_type == 'amount' )
			{
				$orderPrice -= MoneyLibrary::toMoneyFormat($coupon->discount);
			}

			if ( $coupon->applies_to == 'plan' )
			{
				$subscriptionPrice = $orderPrice;
			}
		}

		// Payment customer
		$paymentCustomer = $paymentHandler->createCustomer($request->get('name'), $request->get('email'));

		if ( !$paymentCustomer )
		{
			return \Redirect::back()->withErrors('Der skete en fejl under betalingen, prøv igen.')->withInput();// todo translate
		}

		// Charge
		$charge = $paymentHandler->makeInitialPayment(MoneyLibrary::toCents($orderPrice), $paymentCustomer);

		if ( !$charge )
		{
			return \Redirect::back()->withErrors('Der skete en fejl under betalingen, prøv igen.')->withInput();// todo translate
		}

		$request->session()->put('charge_id', $charge->id);
		$request->session()->put('payment_customer_id', $paymentCustomer->id);
		$request->session()->put('name', $request->get('name'));
		$request->session()->put('email', $request->get('email'));
		$request->session()->put('address_street', $request->get('address_street'));
		$request->session()->put('address_city', $request->get('address_city'));
		$request->session()->put('address_zipcode', $request->get('address_zipcode'));
		$request->session()->put('address_country', $request->get('address_country'));
		$request->session()->put('company', $request->get('company'));
		$request->session()->put('product_name', $request->get('product_name'));
		$request->session()->put('user_data', $request->get('user_data'));
		$request->session()->put('price', $subscriptionPrice);
		$request->session()->put('order_price', $orderPrice);

		// Redirect
		if ( isset($charge->links) && isset($charge->links->paymentUrl) )
		{
			return \Redirect::to($charge->links->paymentUrl);
		}

		return \Redirect::action('CheckoutController@getVerify', [ 'method' => $request->get('payment_method') ]);
	}

	/**
	 * @param                          $method
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	function getVerify($method, Request $request)
	{
		$paymentMethod = new PaymentHandler(PaymentDelegator::getMethod($method));

		$isSuccessful = $paymentMethod->isChargeValid($request->session()->get('charge_id'));

		if ( !$isSuccessful )
		{
			return \Redirect::action('CheckoutController@getCheckout')->withErrors('Der skete en fejl under betalingen, prøv igen!')->withInput([
				'name'            => $request->session()->get('name'),
				'email'           => $request->session()->get('email'),
				'address_street'  => $request->session()->get('address_street'),
				'address_city'    => $request->session()->get('address_city'),
				'address_country' => $request->session()->get('address_country'),
				'address_country' => $request->session()->get('address_country'),
				'company'         => $request->session()->get('company')
			]); // todo translate
		}

		// Info
		$password = str_random(8);
		$userData = json_decode($request->session()->get('user_data', '{}'));
		$product  = Product::where('name', $request->session()->get('product_name', 'subscription'))->first();

		// Taxes
		$taxLibrary = new TaxLibrary($request->session()->get('address_country'));

		// Coupon Repo
		$couponRepository = new CouponRepository();

		// User
		$user = User::create([
			'name'     => ucwords($request->session()->get('name')),
			'email'    => $request->session()->get('email'),
			'password' => bcrypt($password),
			'type'     => 'user'
		]);

		// Customer
		$user->getCustomer()->setCustomerAttributes([
			'address_city'    => $request->session()->get('address_city'),
			'address_line1'   => $request->session()->get('address_street'),
			'address_country' => $request->session()->get('address_country'),
			'address_postal'  => $request->session()->get('address_zipcode'),
			'company'         => $request->session()->get('company'),
		]);

		// Plan
		$user->getCustomer()->getPlan()->update([
			'payment_customer_token' => $request->session()->get('payment_customer_id'),
			'payment_method'         => $method
		]);

		// Giftcard
		$giftcard = null;

		if ( $request->session()->has('giftcard_id') && $request->session()->has('giftcard_token') && $request->session()->get('product_name') == 'subscription' )
		{
			$giftcard = Giftcard::where('id', $request->session()->get('giftcard_id'))
								->where('token', $request->session()->get('giftcard_token'))
								->where('is_used', 0)
								->first();
		}

		// Coupon
		$coupon            = $couponRepository->findByCoupon($request->get('coupon', ''));
		$subscriptionPrice = $request->session()->get('price');
		$orderPrice        = $request->session()->get('order_price');

		if ( $coupon )
		{
			if ( $coupon->discount_type == 'percentage' )
			{
				$orderPrice -= $orderPrice * ($coupon->discount / 100);
			}
			elseif ( $coupon->discount_type == 'amount' )
			{
				$orderPrice -= MoneyLibrary::toMoneyFormat($coupon->discount);
			}

			if ( $coupon->applies_to == 'plan' )
			{
				$subscriptionPrice = $orderPrice;
			}
		}

		// Subscription or not
		if ( $product->is_subscription == 1 )
		{
			// fixme userData being null/false if failed somewhere.
			$user->getCustomer()->update([
				'birthdate' => $userData->birthdate,
				'gender'    => $userData->gender == 1 ? 'male' : 'female'
			]);

			$user->getCustomer()->getPlan()->update([
				'price'                     => MoneyLibrary::toCents($subscriptionPrice),
				'price_shipping'            => 0, // todo un-hardcode
				'subscription_started_at'   => Date::now(),
				'subscription_rebill_at'    => Date::now()->addMonth(),
				'subscription_cancelled_at' => null
			]);

			$user->getCustomer()->setCustomerAttributes([
				'user_data.gender'           => $userData->gender,
				'user_data.birthdate'        => $userData->birthdate,
				'user_data.age'              => $userData->age, // todo update this each month
				'user_data.skin'             => $userData->skin,
				'user_data.outside'          => $userData->outside,
				'user_data.pregnant'         => $userData->pregnant,
				'user_data.diet'             => $userData->diet,
				'user_data.sports'           => $userData->sports,
				'user_data.lacks_energy'     => $userData->lacks_energy,
				'user_data.smokes'           => $userData->smokes,
				'user_data.immune_system'    => $userData->immune_system,
				'user_data.vegetarian'       => $userData->vegetarian,
				'user_data.joints'           => $userData->joints,
				'user_data.stressed'         => $userData->stressed,
				'user_data.foods.fruits'     => $userData->foods->fruits,
				'user_data.foods.vegetables' => $userData->foods->vegetables,
				'user_data.foods.bread'      => $userData->foods->bread,
				'user_data.foods.wheat'      => $userData->foods->wheat,
				'user_data.foods.dairy'      => $userData->foods->dairy,
				'user_data.foods.meat'       => $userData->foods->meat,
				'user_data.foods.fish'       => $userData->foods->fish,
				'user_data.foods.butter'     => $userData->foods->butter
			]);
		}
		else
		{
			$user->getCustomer()->getPlan()->update([
				'price'                     => MoneyLibrary::toCents($subscriptionPrice),
				'price_shipping'            => 0, // todo un-hardcode
				'subscription_cancelled_at' => date('Y-m-d H:i:s')
			]);
		}

		// Giftcard, set balance
		if ( $giftcard )
		{
			$user->getCustomer()->setBalance($giftcard->worth);
		}

		if ( str_contains($product->name, 'giftcard') )
		{
			$giftcard = Giftcard::create([
				'token' => strtoupper(str_random()),
				'worth' => $product->price
			]);
		}

		if ( $coupon )
		{
			$coupon->reduceUsagesLeft();
		}

		if ( $giftcard )
		{
			$giftcard->markUsed();
		}

		$data = [
			'password'      => $password,
			'giftcard'      => $product->is_subscription == 0 ? ($giftcard ? $giftcard->token : null) : null,
			'description'   => trans("products.{$product->name}"),
			'priceTotal'    => MoneyLibrary::toCents($orderPrice),
			'priceSubtotal' => MoneyLibrary::toCents($orderPrice * $taxLibrary->reversedRate()),
			'priceTaxes'    => MoneyLibrary::toCents($orderPrice * $taxLibrary->rate())
		];

		$mailEmail = $user->getEmail();
		$mailName  = $user->getName();

		\Event::fire(new CustomerWasBilled($user->getCustomer(), MoneyLibrary::toCents($orderPrice), $request->session()->get('charge_id'), $product->name, false, 0, $coupon));

		\Mail::queue('emails.order', $data, function ($message) use ($mailEmail, $mailName)
		{
			$message->to($mailEmail, $mailName);
			$message->subject(trans('checkout.mail.subject'));
		});

		if ( $product->is_subscription == 1 )
		{
			$request->session()->flush();
			$upsellToken = str_random();
			\Auth::login($user, true);
			$request->session()->put('upsell_token', $upsellToken);
			$request->session()->put('product_name', $product->name);

			return \Redirect::action('CheckoutController@getSuccess')->with([ 'order_created' => true, 'upsell' => true ]);
		}

		return \Redirect::action('CheckoutController@getSuccessNonSubscription', [ 'token' => $giftcard->token ])->with([ 'order_created' => true ]);
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	function getSuccess(Request $request)
	{
		if ( !$request->session()->has('order_created') )
		{
			return \Redirect::to('/');
		}

		$combinations = \Auth::user()->getCustomer()->getCombinations();

		return view('checkout.success', [ 'combinations' => $combinations ]);
	}

	/**
	 * @param                          $token
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	function getSuccessNonSubscription($token, Request $request)
	{
		if ( !$request->session()->has('order_created') )
		{
			return \Redirect::to('/');
		}

		return view('checkout.success', [
			'giftcardToken' => $token
		]);
	}

	/**
	 * @param \App\Apricot\Repositories\CouponRepository $couponRepository
	 * @param \Illuminate\Http\Request                   $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	function applyCoupon(CouponRepository $couponRepository, Request $request)
	{
		if ( is_null($request->get('coupon')) || $request->get('coupon') == '' )
		{
			return \Response::json([ 'message' => trans('checkout.messages.coupon-missing') ], 400);
		}

		$coupon = $couponRepository->findByCoupon($request->get('coupon'));

		if ( !$coupon )
		{
			return \Response::json([ 'message' => trans('checkout.messages.no-such-coupon') ], 400);
		}

		return \Response::json([
			'message' => trans('checkout.messages.coupon-added'),
			'coupon'  => [
				'description'   => $coupon->description,
				'applies_to'    => $coupon->applies_to,
				'discount_type' => $coupon->discount_type,
				'discount'      => $coupon->discount,
				'code'          => $coupon->code
			]
		], 200);
	}
	
}