<?php namespace App\Http\Controllers;

use App\Customer;
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
		if ( 1 == 1 )
		{
			// todo: check if order exists and belongs to customer
		}
		return view('account.transaction', [
			'order' => '' // todo: the order
		]);
	}

	function getSettingsBilling()
	{
		return view('account.settings.billing');
	}

	function getSettingsBasic()
	{
		return view('account.settings.basic');
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
		return 'delete!';
	}
	
}