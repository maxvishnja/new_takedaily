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

	Route::post('flow', function ()
	{
		$userData = json_decode(Request::get('user_data'));

		dd($userData);
	});

	Route::get('signup', function ()
	{
		return view('signup'); // todo
	});

	Route::post('signup', function ()
	{
		return '';
	});

	Route::get('pick-and-mix', function ()
	{
		return view('products', [
			'products' => \App\Product::all()
		]);
	});

	Route::get('cart', function ()
	{
		return view('cart');
	});

	Route::group([ 'middleware' => 'secure' ], function ()
	{
		Route::get('checkout', function ()
		{
			return view('checkout');
		});
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
		Route::get('transactions/{id}', 'AccountController@getTransaction');

		Route::get('settings/basic', 'AccountController@getSettingsBasic');
		Route::post('settings/basic', 'AccountController@postSettingsBasic');  // Todo

		Route::get('settings/subscription', 'AccountController@getSettingsSubscription');
		Route::post('settings/subscription/snooze', 'AccountController@postSettingsSubscriptionSnooze');
		Route::get('settings/subscription/start', 'AccountController@getSettingsSubscriptionStart');
		Route::get('settings/subscription/cancel', 'AccountController@getSettingsSubscriptionCancel'); // todo

		Route::get('settings/billing', 'AccountController@getSettingsBilling');
		Route::get('settings/billing/delete', 'AccountController@getSettingsBillingRemove');
		Route::get('settings/billing/add', 'AccountController@getSettingsBillingAdd');
		Route::get('settings/billing/refresh', 'AccountController@getSettingsBillingRefresh');

		Route::get('settings/delete', 'AccountController@getSettingsDelete');
		Route::post('settings/delete', 'AccountController@postSettingsDelete');
	});

	/*
	 * Dashboard routes
	 */
	Route::group([ 'middleware' => 'admin', 'prefix' => 'dashboard' ], function ()
	{
		$orderRepo    = new \App\Apricot\Repositories\OrderRepository();
		$customerRepo = new \App\Apricot\Repositories\CustomerRepository();

		view()->share('sidebar_numOrders', $orderRepo->getNew()->count());

		Route::get('login', 'Auth\DashboardAuthController@showLoginForm');
		Route::post('login', 'Auth\DashboardAuthController@login');

		Route::get('/', function () use ($orderRepo, $customerRepo)
		{
			return view('admin.home', [
				'orders_today'    => $orderRepo->getToday()->count(),
				'customers_today' => $customerRepo->getToday()->count(),
				'money_today' => $orderRepo->getToday()->sum('total')
			]);
		});
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
