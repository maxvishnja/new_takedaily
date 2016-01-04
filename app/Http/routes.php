<?php

Route::group([ 'middleware' => 'web' ], function ()
{
	/*
	 * Auth routes
	 */
	Route::auth();

	/*
	 * Main routes
	 */
	Route::get('/', function ()
	{
		return view('home');
	});

	Route::get('flow', function ()
	{
		return view('flow');
	});

	Route::get('pick-and-mix', function ()
	{
		return view('products');
	});

	Route::get('cart', function ()
	{
		return view('cart');
	});

	Route::get('checkout', function ()
	{
		return view('checkout');
	});

	/*
	 * Account routes
	 */
	Route::group([ 'middleware' => 'user', 'prefix' => 'account' ], function ()
	{
		Route::get('settings', function ()
		{
			// Redirect to the correct route (../basic)
			return redirect('account/settings/basic');
		});

		Route::get('/', 'AccountController@getHome');
		Route::get('info', 'AccountController@getInfo');
		Route::get('transactions', 'AccountController@getTransactions');
		Route::get('settings/basic', 'AccountController@getSettingsBasic');  // Todo: add newsletter field to database
		Route::get('settings/subscription', 'AccountController@getSettingsSubscription');
		Route::get('settings/billing', 'AccountController@getSettingsBilling');
		Route::get('settings/delete', 'AccountController@getSettingsDelete');
		Route::post('settings/delete', 'AccountController@postSettingsDelete');
	});

	/*
	 * Dashboard routes
	 */
	Route::group([ 'middleware' => 'admin', 'prefix' => 'dashboard' ], function ()
	{
		Route::get('login', 'Auth\DashboardAuthController@showLoginForm');
		Route::post('login', 'Auth\DashboardAuthController@login');

		Route::get('/', function () { return view('admin.home'); });
		Route::resource('customers', 'Dashboard\CustomerController');
		Route::resource('orders', 'Dashboard\OrderController');
		Route::resource('coupons', 'Dashboard\CouponController');
		Route::resource('settings', 'Dashboard\SettingController');
		Route::resource('products', 'Dashboard\ProductController');
		Route::resource('pages', 'Dashboard\PageController');
	});

	/*
	 * CMS dynamic routing
	 */
	Route::get('{identifier}', function ($identifier)
	{
		echo 'Load CMS page, if exists - otherwise, abort 404: ' . $identifier;
		//abort(404, 'Siden blev ikke fundet');
	});
});
