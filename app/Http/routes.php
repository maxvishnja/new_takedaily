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

	Route::post('flow', function (\App\Apricot\Libraries\CombinationLibrary $combinationLibrary, \Illuminate\Http\Request $request)
	{
		$userData = json_decode($request->get('user_data'));
		$combinationLibrary->generateResult($userData);

		$request->session()->put('my_combination', $combinationLibrary->getResult());
		$request->session()->put('user_data', $userData);

		return Redirect::action('CheckoutController@getCheckout');
	});

	/*
	 * Signup
	 */
	Route::get('signup', function ()
	{
		return view('signup'); // todo
	});

	Route::post('signup', function ()
	{
		return '';
	});

	/*
	 * Checkout
	 */
	Route::group([ 'middleware' => 'secure', 'prefix' => 'checkout' ], function ()
	{
		Route::get('', 'CheckoutController@getCheckout');
		Route::post('', 'CheckoutController@postCheckout');
		Route::post('apply-coupon', 'CheckoutController@applyCoupon');

		Route::group([ 'middleware' => [ 'auth', 'user' ] ], function ()
		{
			Route::get('success', 'CheckoutController@getSuccess');
		});
	});

	/*
	 * Account routes
	 */
	Route::group([ 'middleware' => [ 'auth', 'user' ], 'prefix' => 'account' ], function ()
	{
		Route::get('settings', function ()
		{
			// Redirect to the correct route (../basic)
			return redirect('account/settings/basic');
		});

		Route::get('/', 'AccountController@getHome');
		Route::post('/update-preferences', 'AccountController@updatePreferences');

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
	Route::group([ 'prefix' => 'dashboard', 'middleware' => 'admin' ], function ()
	{
		view()->composer('admin.sidebar', function ($view)
		{
			$orderRepo = new \App\Apricot\Repositories\OrderRepository();
			$view->with('sidebar_numOrders', $orderRepo->getNew()->count());
		});

		Route::get('login', 'Auth\DashboardAuthController@showLoginForm');
		Route::post('login', 'Auth\DashboardAuthController@login');

		Route::get('/', function ()
		{
			$orderRepo    = new \App\Apricot\Repositories\OrderRepository();
			$customerRepo = new \App\Apricot\Repositories\CustomerRepository();

			return view('admin.home', [
				'orders_today'    => $orderRepo->getToday()->count(),
				'customers_today' => $customerRepo->getToday()->count(),
				'money_today'     => $orderRepo->getToday()->whereNotIn('state', [ 'new', 'cancelled' ])->sum('total')
			]);
		});
		Route::resource('customers', 'Dashboard\CustomerController');
		Route::get('customers/newpass/{id}', 'Dashboard\CustomerController@newPass');
		Route::get('customers/bill/{id}', 'Dashboard\CustomerController@bill');
		Route::get('customers/cancel/{id}', 'Dashboard\CustomerController@cancel');

		Route::resource('orders', 'Dashboard\OrderController');
		Route::get('orders/mark-sent/{id}', 'Dashboard\OrderController@markSent');
		Route::resource('coupons', 'Dashboard\CouponController');
		Route::resource('settings', 'Dashboard\SettingController');
		Route::resource('products', 'Dashboard\ProductController');
		Route::resource('pages', 'Dashboard\PageController');
	});

	Route::group([ 'middleware' => 'ajax' ], function ()
	{
		Route::post('call-me', function (\Illuminate\Http\Request $request)
		{
			$request->get('phone');
			$request->get('period');

			// todo store this in DB and show in admin! fixme

			return Response::json([ 'message' => 'Tak, vi ringer til dig snarest!' ]);
		});
	});

	/*
	 * CMS dynamic routing
	 */
	Route::get('{identifier}', function ($identifier)
	{
		$repo = new \App\Apricot\Repositories\PageRepository();
		$page = $repo->findByIdentifier($identifier)->first();

		if ( !$page )
		{
			abort(404);
		}

		return view('page', [
			'page' => $page
		]);
	});
});
