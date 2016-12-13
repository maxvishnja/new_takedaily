<?php namespace App\Http\Controllers;

use App\Apricot\Libraries\PillLibrary;
use App\Customer;
use App\User;
use App\Vitamin;
use Illuminate\Http\Request;
use Stripe\Error\Card;

class AccountController extends Controller
{

	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var Customer
	 */
	private $customer;

	function __construct()
	{
		$this->middleware( 'user' );
		$this->user = \Auth::user();
		if ( $this->user && $this->user->getCustomer() )
		{
			$this->customer = $this->user->getCustomer();
			\View::share( 'customer', $this->customer );
		}

	}

	function getHome()
	{
		$orders = $this->customer->getOrders();
		$plan = $this->customer->getPlan();

		return view( 'account.my-takedaily', compact( 'orders', 'plan' ) );
	}

	function updatePreferences( Request $request )
	{
		if ( ! $this->customer || $this->customer->plan->isCustom() )
		{
			return redirect()->back()->withErrors( trans( 'account.general.errors.custom-package-cant-change' ) );
		}

		return redirect()->route( 'flow' );
	}

	function updateVitamins()
	{
		$combinations = $this->user->getCustomer()->calculateCombinations();
		$vitamins     = [];

		foreach ( $combinations as $vitaminCode )
		{
			$vitamin = Vitamin::select( 'id' )->whereCode( $vitaminCode )->first();

			if ( $vitamin )
			{
				$vitamins[] = $vitamin->id;
			}
		}

		$this->user->getCustomer()->getPlan()->update( [
			'vitamins' => json_encode( $vitamins )
		] );

		return \Redirect::action( 'AccountController@getHome' )->with( 'success', trans( 'account.general.successes.vitamins-updated' ) );
	}

	function getTransactions()
	{
		return view( 'account.transactions', [
			'orders' => $this->customer->getOrders()
		] );
	}

	function getTransaction( $id )
	{
		$order = $this->customer->getOrderById( $id );

		if ( ! $order )
		{
			return \Redirect::to( '/account/transactions' )->withErrors( trans( 'messages.errors.transactions.not_found' ) );
		}

		return view( 'account.transaction', [
			'order' => $order
		] );
	}

	function getSettingsBilling()
	{
		$sources = $this->customer->getPaymentMethods();

		return view( 'account.settings.billing', [
			'sources' => $sources['methods'],
			'method'  => $sources['type']
		] );
	}

	function getSettingsBillingRemove()
	{
		if ( ! $this->customer->removePaymentOption() )
		{
			return redirect()->action( 'AccountController@getSettingsBilling' )->withErrors( trans( 'messages.successes.billing.removing-failed' ) );
		}

		return redirect()->action( 'AccountController@getSettingsBilling' )->with( 'success', trans( 'messages.successes.billing.removed' ) );
	}

	function getSettingsBillingAdd()
	{
		if ( count( $this->customer->getPaymentMethods()['methods'] ) > 0 )
		{
			return \Redirect::action( 'AccountController@getSettingsBilling' );
		}

		return view( 'account.settings.billing-add' );
	}

	function postSettingsBillingAdd( Request $request )
	{
		$user = \Auth::user();

		if ( count( $this->customer->getPaymentMethods()['methods'] ) == 0 )
		{
			try
			{
				$stripeCustomer = Customer::create( [
					"description" => "Customer for {$user->getEmail()}",
					"source"      => $request->get( 'stripeToken' )
				] );

				$user->getCustomer()->getPlan()->update( [
					'stripe_token' => $stripeCustomer->id
				] );
			} catch ( Card $ex )
			{
				return \Redirect::back()->withErrors( [ trans( 'checkout.messages.payment-error', [ 'error' => $ex->getMessage() ] ) ] )->withInput();
			} catch ( \Exception $ex )
			{
				return \Redirect::back()->withErrors( [ trans( 'checkout.messages.payment-error', [ 'error' => $ex->getMessage() ] ) ] )->withInput();
			} catch ( \Error $ex )
			{
				return \Redirect::back()->withErrors( [ trans( 'checkout.messages.payment-error', [ 'error' => $ex->getMessage() ] ) ] )->withInput();
			}
		}
		else
		{
			$stripeCustomer = $user->getCustomer()->getStripeCustomer();
			try
			{
				$stripeCustomer->sources->create( [
					'source' => $request->get( 'stripeToken' )
				] );
			} catch ( Card $ex )
			{
				return \Redirect::back()->withErrors( [ trans( 'checkout.messages.payment-error', [ 'error' => $ex->getMessage() ] ) ] )->withInput();
			} catch ( \Exception $ex )
			{
				return \Redirect::back()->withErrors( [ trans( 'checkout.messages.payment-error', [ 'error' => $ex->getMessage() ] ) ] )->withInput();
			} catch ( \Error $ex )
			{
				return \Redirect::back()->withErrors( [ trans( 'checkout.messages.payment-error', [ 'error' => $ex->getMessage() ] ) ] )->withInput();
			}
		}

		return \Redirect::action( 'AccountController@getSettingsBilling' )->with( 'success', trans( 'checkout.messages.success.card-added' ) );
	}

	function getSettingsBasic()
	{
		return view( 'account.settings.basic', [
			'attributes' => $this->customer->getCustomerAttributes( true )
		] );
	}

	function postSettingsBasic( Request $request )
	{
		$this->validate( $request, [
			'email'    => 'required|email|unique:users,email,' . $this->user->id,
			'name'     => 'required',
			'password' => 'confirmed'
		] );

		foreach ( $request->input( 'attributes' ) as $attributeId => $attributeValue )
		{
			$this->customer->customerAttributes()->where( 'id', $attributeId )->update( [ 'value' => $attributeValue ] );
		}

		$this->customer->birthday          = $request->get( 'birthday' );
		$this->customer->accept_newletters = $request->get( 'newsletters', 0 );
		$this->customer->gender            = $request->get( 'gender', 'Male' );
		$this->user->email                 = $request->get( 'email' );
		$this->user->name                  = $request->get( 'name' );

		if ( $request->get( 'password' ) != '' )
		{
			$this->user->password = bcrypt( $request->get( 'password' ) );
		}

		$this->customer->save();
		$this->user->save();

		return \Redirect::to( '/account/settings/basic' )->with( 'success', trans( 'messages.successes.profile.updated' ) );
	}

	function getSettingsSubscription()
	{
		return view( 'account.settings.subscription', [
			'plan' => $this->customer->getPlan()
		] );
	}

	function postSettingsSubscriptionSnooze( Request $request )
	{
		if ( ! $this->customer->getPlan()->isSnoozeable() )
		{
			return redirect()->action( 'AccountController@getSettingsSubscription' )->withErrors( trans( 'messages.errors.subscription.not-snoozed' ) );
		}

		if ( $request->get( 'days', 7 ) > 28 )
		{
			return redirect()->back()->withErrors( trans( 'account.general.errors.max-snooze' ) );
		}

		$this->customer->getPlan()->snooze( $request->get( 'days', 7 ) );

		return redirect()
			->action( 'AccountController@getSettingsSubscription' )
			->with( 'success', trans( 'messages.successes.subscription.snoozed', [ 'days' => $request->get( 'days', 7 ) ] ) );
	}

	function getSettingsSubscriptionStart()
	{
		if ( $this->customer->getPlan()->isActive() )
		{
			return \Redirect::back();
		}

		$this->customer->getPlan()->start();

		return redirect()->action( 'AccountController@getSettingsSubscription' )->with( 'success', trans( 'messages.successes.subscription.started' ) );
	}

	function getSettingsSubscriptionRestart()
	{
		if ( $this->customer->getPlan()->isActive() )
		{
			return \Redirect::back();
		}

		$this->customer->getPlan()->startFromToday();

		return redirect()->action( 'AccountController@getSettingsSubscription' )->with( 'success', trans( 'messages.successes.subscription.started' ) );
	}

	function getSettingsSubscriptionCancel()
	{
		if ( ! $this->customer->getPlan()->isCancelable() )
		{
			return \Redirect::back();
		}

		$this->customer->getPlan()->cancel();

		return redirect()->action( 'AccountController@getSettingsSubscription' )->with( 'success', trans( 'messages.successes.subscription.cancelled' ) );
	}

}