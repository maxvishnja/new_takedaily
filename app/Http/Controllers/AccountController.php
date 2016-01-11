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
		$this->user     = \Auth::user();
		$this->customer = $this->user->getCustomer();

		\View::share('customer', $this->customer);
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
			return \Redirect::to('/account/transactions')->withErrors([
				'Ordren findes ikke!' // todo: translate
			]);
		}

		return view('account.transaction', [
			'order' => $order
		]);
	}

	function getSettingsBilling()
	{
		return view('account.settings.billing');
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

		// Todo: save new settings (non-attributes)
		// Todo: allow editing password too

		return \Redirect::to('/account/settings/basic')->with('success', 'Opdateret!'); // todo: translate
	}

	function getSettingsSubscription()
	{
		return view('account.settings.subscription');
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