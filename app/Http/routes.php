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

	Route::get('gifting', function ()
	{
		return view('gifting');
	});

	Route::post('flow', function (\App\Apricot\Libraries\CombinationLibrary $combinationLibrary, \Illuminate\Http\Request $request)
	{
		$userData = json_decode($request->get('user_data'));

		Session::put('user_data', $userData);
		Session::put('product_name', $request->get('product_name'));

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

	Route::get('gc/{token}', function ($token, \Illuminate\Http\Request $request)
	{
		$giftcard = \App\Giftcard::where('token', $token)->where('is_used', 0)->first();

		if ( !$giftcard )
		{
			abort(404);
		}

		$request->session()->put('giftcard_id', $giftcard->id);
		$request->session()->put('giftcard_token', $giftcard->token);

		return Redirect::to('flow')->with('success', 'Du skal udfylde dette spørgeskema for at gøre brug af gavekortet. Det tager 2 minutter');
	});

	Route::get('locale/{locale}', function ($locale)
	{
		Session::put('locale', $locale);
		App::setLocale($locale);
	});

	/*
	 * Checkout
	 */
	Route::group([ 'middleware' => [ 'secure', 'nonAdmin' ], 'prefix' => 'checkout' ], function ()
	{
		Route::get('', 'CheckoutController@getCheckout');
		Route::post('', 'CheckoutController@postCheckout');
		Route::post('apply-coupon', 'CheckoutController@applyCoupon');

		Route::group([ 'middleware' => [ 'auth', 'user' ] ], function ()
		{
			Route::get('success', 'CheckoutController@getSuccess');
			Route::get('success-giftcard/{token}', 'CheckoutController@getSuccessNonSubscription');
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
	});

	/*
	 * Dashboard routes
	 */
	Route::group([ 'prefix' => 'dashboard', 'middleware' => 'admin' ], function ()
	{
		view()->composer('admin.sidebar', function ($view)
		{
			$orderRepo = new \App\Apricot\Repositories\OrderRepository();
			$view->with('sidebar_numOrders', $orderRepo->getNotShipped()->count());

			$callRepo = new \App\Apricot\Repositories\CallRepository();
			$view->with('sidebar_numCalls', $callRepo->getRequests()->count());
		});

		Route::get('login', 'Auth\DashboardAuthController@showLoginForm');
		Route::post('login', 'Auth\DashboardAuthController@login');

		Route::get('/', function ()
		{
			$orderRepo    = new \App\Apricot\Repositories\OrderRepository();
			$customerRepo = new \App\Apricot\Repositories\CustomerRepository();

			$salesYear     = $orderRepo->getMonthlySales();
			$customersYear = $customerRepo->getMonthlyNew();

			return view('admin.home', [
				'orders_today'    => $orderRepo->getToday()->count(),
				'customers_today' => $customerRepo->getToday()->count(),
				'money_today'     => $orderRepo->getToday()->whereNotIn('state', [ 'new', 'cancelled' ])->sum('total'),
				'sales_year'      => $salesYear,
				'customers_year'  => $customersYear
			]);
		});
		Route::resource('customers', 'Dashboard\CustomerController');
		Route::get('customers/newpass/{id}', 'Dashboard\CustomerController@newPass');
		Route::get('customers/bill/{id}', 'Dashboard\CustomerController@bill');
		Route::get('customers/cancel/{id}', 'Dashboard\CustomerController@cancel');


		Route::resource('calls', 'Dashboard\CallController');
		Route::get('calls/mark-done/{id}', 'Dashboard\CallController@markDone');


		Route::resource('rewrites', 'Dashboard\RewriteController');
		Route::get('rewrites/remove/{id}', 'Dashboard\RewriteController@remove');

		Route::resource('orders', 'Dashboard\OrderController');
		Route::get('orders/mark-sent/{id}', 'Dashboard\OrderController@markSent');
		Route::get('orders/refund/{id}', 'Dashboard\OrderController@refund');
		Route::resource('coupons', 'Dashboard\CouponController');
		Route::resource('settings', 'Dashboard\SettingController');
		Route::resource('products', 'Dashboard\ProductController');
		Route::resource('pages', 'Dashboard\PageController');
	});

	Route::group([ 'middleware' => 'ajax' ], function ()
	{
		Route::post('call-me', function (\Illuminate\Http\Request $request)
		{
			// todo validate
			\App\Call::create([
				'phone'  => $request->get('phone'),
				'period' => $request->get('period'),
				'status' => 'requested'
			]);

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
