<?php namespace App\Http\Controllers;

use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Repositories\CouponRepository;
use App\User;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Stripe;

class CheckoutController extends Controller
{

	function __construct()
	{

	}

	function getCheckout(Request $request)
	{
		if ( !$request->session()->has('user_data') )
		{
			return \Redirect::to('/flow')->withErrors([ 'Vi skal finde dine vitaminer før du kan handle.' ]);
		}

		return view('checkout.index', [
			'user_data' => $request->session()->get('user_data')
		]);
	}

	function postCheckout(CouponRepository $couponRepository, Request $request)
	{
		$this->validate($request, [
			'info.email'           => 'email|required|unique:users,email' . (\Auth::user() ? (',' . \Auth::user()->id) : ''),
			'info.name'            => 'required',
			'info.address_street'  => 'required',
			'info.address_zipcode' => 'required',
			'info.address_city'    => 'required',
			'info.address_country' => 'required',
			'stripeToken'          => 'required'
		], [
			'info.email.unique' => 'E-mail adressen er allerede taget.',
			'info.email.email'  => 'E-mail adressen er ikke gyldig.',
		]);


		Stripe::setApiKey(env('STRIPE_API_SECRET_KEY', ''));

		$stripeToken = $request->get('stripeToken');
		$coupon      = $couponRepository->findByCoupon($request->get('coupon', ''));
		$userData    = json_decode($request->get('user_data', '{}'));
		$info        = $request->get('info');
		$password    = str_random(8);
		$email       = strtolower($info['email']);


		$orderPrice        = 149; // todo DON'T HARDCODE IT
		$subscriptionPrice = 149; // todo DON'T HARDCODE IT

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

		if ( \Auth::guest() )
		{
			try
			{
				$stripeCustomer = Customer::create([
					"description" => "Customer for {$email}",
					"source"      => $stripeToken
				]);
			} catch( Card $ex )
			{
				return \Redirect::back()->withErrors([ 'Betalingen blev ikke godkendt, prøv igen. ' . $ex->getMessage() ])->withInput();
			} catch( \Exception $ex )
			{
				return \Redirect::back()->withErrors([ 'Betalingen blev ikke godkendt, prøv igen. ' . $ex->getMessage() ])->withInput();
			} catch( \Error $ex )
			{
				return \Redirect::back()->withErrors([ 'Betalingen blev ikke godkendt, prøv igen. ' . $ex->getMessage() ])->withInput();
			}

			$user = User::create([
				'name'     => ucwords($info['name']),
				'email'    => $email,
				'password' => bcrypt($password),
				'type'     => 'user'
			]);

			\Auth::login($user, true);
		}
		else
		{
			$user = \Auth::user();
		}

		if ( $user->getCustomer()->getPlan()->hasNoStripeCustomer() )
		{
			try
			{
				$stripeCustomer = Customer::create([
					"description" => "Customer for {$email}",
					"source"      => $stripeToken
				]);

				$user->getCustomer()->getPlan()->update([
					'stripe_token' => $stripeCustomer->id
				]);
			} catch( Card $ex )
			{
				return \Redirect::back()->withErrors([ 'Betalingen blev ikke godkendt, prøv igen. ' . $ex->getMessage() ])->withInput();
			} catch( \Exception $ex )
			{
				return \Redirect::back()->withErrors([ 'Betalingen blev ikke godkendt, prøv igen. ' . $ex->getMessage() ])->withInput();
			} catch( \Error $ex )
			{
				return \Redirect::back()->withErrors([ 'Betalingen blev ikke godkendt, prøv igen. ' . $ex->getMessage() ])->withInput();
			}
		}
		else
		{
			$stripeCustomer = $user->getCustomer()->getStripeCustomer();
		}

		$user->getCustomer()->setCustomerAttributes([
			'address_city'    => $info['address_city'],
			'address_line1'   => $info['address_street'],
			'address_country' => $info['address_country'],
			'address_postal'  => $info['address_zipcode'],
			'company'         => $info['company'] ?: '',
		]);

		$user->getCustomer()->update([
			'birthdate' => $userData->birthdate,
			'gender'    => $userData->gender == 1 ? 'male' : 'female'
		]);

		$user->getCustomer()->getPlan()->update([
			'stripe_token'            => $stripeCustomer->id,
			'price'                   => MoneyLibrary::toCents($subscriptionPrice),
			'price_shipping'          => 0,
			'subscription_started_at' => Date::now(),
			'subscription_rebill_at'  => Date::now()->addMonth()
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

		$stripeCharge = $user->getCustomer()->charge(MoneyLibrary::toCents($orderPrice), true);

		if ( !$stripeCharge )
		{
			return \Redirect::back()->withErrors([ 'Betalingen blev ikke godkendt, prøv igen. ' . \Session::get('error_message') ])->withInput();
		}

		if ( $coupon )
		{
			$coupon->reduceUsagesLeft();
		}

		return \Redirect::action('CheckoutController@getSuccess');
	}

	function getSuccess()
	{
		$combinations = \Auth::user()->getCustomer()->getCombinations();

		return view('checkout.success', [ 'combinations' => $combinations ]);
	}

	function applyCoupon(CouponRepository $couponRepository, Request $request)
	{
		if ( is_null($request->get('coupon')) || $request->get('coupon') == '' )
		{
			return \Response::json([ 'message' => 'Du skal indtaste en kuponkode.' ], 400);
		}

		$coupon = $couponRepository->findByCoupon($request->get('coupon'));

		if ( !$coupon )
		{
			return \Response::json([ 'message' => 'Kuponkoden findes ikke.' ], 400);
		}

		return \Response::json([
			'message' => 'Kuponkoden blev tilføjet!',
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