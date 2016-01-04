<?php namespace App\Http\Controllers;

class AccountController extends Controller
{

	function __construct()
	{
		$this->middleware('user');
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
		return view('account.transactions');
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