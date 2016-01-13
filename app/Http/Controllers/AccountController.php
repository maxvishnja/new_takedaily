<?php namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\User;

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
		$this->middleware('user');
		$this->user = \Auth::user();
		if ( $this->user && $this->user->getCustomer() )
		{
			$this->customer = $this->user->getCustomer();
			\View::share('customer', $this->customer);
		}

	}

	function getHome()
	{
		return view('account.home');
	}

	function getInfo()
	{
		return view('account.info');
	}

	function getTransactions()
	{
		return view('account.transactions', [
			'orders' => $this->customer->getOrders()
		]);
	}

	function getTransaction($id)
	{
		$order = $this->customer->getOrderById($id);

		if ( !$order )
		{
			return \Redirect::to('/account/transactions')->withErrors(trans('messages.errors.transactions.not_found'));
		}

		return view('account.transaction', [
			'order' => $order
		]);
	}

	function getSettingsBilling()
	{
		$source = $this->customer->getStripePaymentSource();

		return view('account.settings.billing', [
			'source' => $source
		]);
	}

	function getSettingsBillingRemove()
	{
		if( ! $this->customer->removePaymentOption() )
		{
			return redirect()->action('AccountController@getSettingsBilling')->withErrors(trans('messages.successes.billing.removing-failed'));
		}

		return redirect()->action('AccountController@getSettingsBilling')->with('success', trans('messages.successes.billing.removed'));
	}

	function getSettingsBillingAdd()
	{
		// todo
	}

	function getSettingsBillingRefresh()
	{
		\Cache::forget('stripe_customer_for_customer_' . $this->customer->id);

		return redirect()->action('AccountController@getSettingsBilling')->with('success', trans('messages.successes.billing.refreshed'));
	}

	function getSettingsBasic()
	{
		return view('account.settings.basic', [
			'attributes' => $this->customer->getCustomerAttributes(true)
		]);
	}

	function postSettingsBasic(Request $request)
	{
		foreach ( $request->input('attributes') as $attributeId => $attributeValue )
		{
			$this->customer->customerAttributes()->where('id', $attributeId)->update([ 'value' => $attributeValue ]);
		}

		$this->validate($request, [
			'email'    => 'required|email|unique:users,email,' . $this->user->id,
			'name'     => 'required',
			'gender'   => 'required|in:male,female',
			'birthday' => 'date',
			'password' => 'confirmed'
		]);

		$this->customer->birthday          = $request->get('birthday');
		$this->customer->accept_newletters = $request->get('newsletters', 0);
		$this->customer->gender            = $request->get('gender', 'Male');
		$this->user->email                 = $request->get('email');
		$this->user->name                  = $request->get('name');

		if ( $request->get('password') != '' )
		{
			$this->user->password = bcrypt($request->get('password'));
		}

		$this->customer->save();
		$this->user->save();

		return \Redirect::to('/account/settings/basic')->with('success', trans('messages.successes.profile.updated'));
	}

	function getSettingsSubscription()
	{
		return view('account.settings.subscription', [
			'plan'         => $this->customer->getPlan(),
			'planProducts' => $this->customer->getPlan()->getProducts()->load('product')
		]);
	}

	function getSettingsSubscriptionPause()
	{
		$this->customer->getPlan()->pause();

		return redirect()->action('AccountController@getSettingsSubscription')->with('success', trans('messages.successes.subscription.paused'));
	}

	function getSettingsSubscriptionStart()
	{
		$this->customer->getPlan()->start();

		return redirect()->action('AccountController@getSettingsSubscription')->with('success', trans('messages.successes.subscription.started'));
	}

	function getSettingsDelete()
	{
		return view('account.settings.delete');
	}

	function postSettingsDelete()
	{
		return 'delete account!';
	}
	
}