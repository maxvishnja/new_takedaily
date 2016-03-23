<?php namespace App\Http\Controllers;

use App\Customer;
use App\User;
use Illuminate\Http\Request;

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


	function updatePreferences(Request $request)
	{
		$userData    = json_decode($request->get('user_data', '{}'));

		\Auth::user()->getCustomer()->update([
			'birthdate' => $userData->birthdate,
			'gender'    => $userData->gender == 1 ? 'male' : 'female'
		]);

		\Auth::user()->getCustomer()->setCustomerAttributes([
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

		return \Redirect::action('AccountController@getHome')->with('success', 'Dine præferencer blev gemt!');
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
		if ( !$this->customer->removePaymentOption() )
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
			'plan' => $this->customer->getPlan()
		]);
	}

	function postSettingsSubscriptionSnooze(Request $request)
	{
		if ( !$this->customer->getPlan()->isSnoozeable() )
		{
			return redirect()->action('AccountController@getSettingsSubscription')->withErrors(trans('messages.errors.subscription.not-snoozed'));
		}

		$this->customer->getPlan()->snooze($request->get('days', 7));

		return redirect()->action('AccountController@getSettingsSubscription')->with('success', trans('messages.successes.subscription.snoozed', [ 'days' => $request->get('days', 7) ]));
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