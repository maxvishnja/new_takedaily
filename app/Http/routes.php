<?php

Route::group([ 'middleware' => 'web' ], function ()
{
	/*
	 * Auth routes
	 */
	Route::get('login', 'Auth\AuthController@showLoginForm');
	Route::post('login', 'Auth\AuthController@login');
	Route::get('logout', 'Auth\AuthController@logout');

	// Password Reset Routes...
	Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
	Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
	Route::post('password/reset', 'Auth\PasswordController@reset');

	/*
	 * Main routes
	 */
	Route::get('/', function ()
	{
		return view('home');
	});

	Route::group([ 'middleware' => 'guest' ], function ()
	{
		Route::get('flow', function ()
		{
			$giftcard = null;

			if ( \Session::has('giftcard_id') && \Session::has('giftcard_token') && \Session::get('product_name', 'subscription') == 'subscription' )
			{
				$giftcard = Giftcard::where('id', \Session::get('giftcard_id'))
									->where('token', \Session::get('giftcard_token'))
									->where('is_used', 0)
									->first();
			}

			$product = \App\Product::whereName(\Session::get('product_name', 'subscription'))->first();

			$shipping      = 0;
			$giftcardWorth = 0;

			if ( $giftcard )
			{
				$giftcardWorth = $giftcard->worth;
			}

			if ( \Session::get('product_name', 'subscription') == 'subscription' )
			{
				$shipping = \App\Apricot\Libraries\MoneyLibrary::toCents(0); // todo get from settings
			}

			$total = $product->price;
			$total += $shipping;

			if ( $giftcard )
			{
				$total -= $giftcard->worth;
			}

			$zone    = new \App\Apricot\Libraries\TaxLibrary(trans('general.tax_zone'));
			$taxRate = $zone->rate();

			$taxes = $product->price * $taxRate;


			$prices = [
				'product'  => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price),
				'total'    => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($total),
				'giftcard' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($giftcardWorth),
				'taxes'    => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($taxes),
				'shipping' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($shipping),
			];

			return view('flow', compact('giftcard', 'product', 'prices'));
		});

		Route::post('flow/recommendations', function (\Illuminate\Http\Request $request)
		{
			$lib = new \App\Apricot\Libraries\CombinationLibrary();

			$lib->generateResult(json_decode($request->get('user_data')));

			$advises = '';

			foreach ( $lib->getAdvises() as $adviseKey => $advise )
			{
				$advises .= '<p>' . $advise . '</p>';
			}

			return Response::json([
				'advises' => $advises,
				'label'   => view('flow-label', [ 'combinations' => $lib->getResult(), 'advises' => $lib->getAdviseInfos() ])->render()
			]);
		});
	});

	Route::post('flow', function (\Illuminate\Http\Request $request)
	{
		$userData = json_decode($request->get('user_data'));

		Session::put('user_data', $userData);
		Session::put('product_name', $request->get('product_name'));

		if ( $request->get('coupon', '') != '' )
		{
			Session::put('applied_coupon', $request->get('coupon'));
		}

		return Redirect::action('CheckoutController@getCheckout');
	});

	Route::post('flow-upsell', function (\Illuminate\Http\Request $request)
	{
		if ( !$request->get('upsell_token') == Session::get('upsell_token') || !Session::has('upsell_token') )
		{
			return Redirect::to('/flow');
		}

		\Auth::logout();

		$coupon = \App\Coupon::create([
			'description'   => 'Upsell discount',
			'code'          => str_random(8),
			'discount'      => 50,
			'applies_to'    => 'order',
			'discount_type' => 'percentage',
			'uses_left'     => 1,
			'valid_from'    => \Jenssegers\Date\Date::now(),
			'valid_to'      => \Jenssegers\Date\Date::now()->addDay()
		]);

		Session::put('applied_coupon', $coupon->code);

		return Redirect::to('/flow');
	});

	Route::get('gifting', function ()
	{
		return view('gifting');
	});

	/*
	 * Signup
	 */
	Route::get('gc/{token}', function ($token, \Illuminate\Http\Request $request)
	{
		$giftcard = \App\Giftcard::where('token', $token)->where('is_used', 0)->first();

		if ( !$giftcard )
		{
			abort(404);
		}

		$request->session()->put('giftcard_id', $giftcard->id);
		$request->session()->put('giftcard_token', $giftcard->token);

		return Redirect::to('flow')->with('success', trans('message.success.giftcard-applied'));
	});

	Route::get('locale/{locale}', function ($locale)
	{
		Session::put('locale', $locale);
		App::setLocale($locale);

		return Redirect::back()->with('success', trans('message.success.locale-set'));
	});

	/*
	 * Checkout
	 */
	Route::group([ 'middleware' => [ 'secure', 'guest' ], 'prefix' => 'checkout' ], function ()
	{
		Route::get('', 'CheckoutController@getCheckout');
		Route::post('', 'CheckoutController@postCheckout');
		Route::post('apply-coupon', 'CheckoutController@applyCoupon');
		Route::get('get-taxrate', 'CheckoutController@getTaxRate');

		// Charge verify
		Route::get('verify/{method}', 'CheckoutController@getVerify');

		// Mollie webhook
		Route::post('mollie', function ($paymentId = 0)
		{
			try
			{
				$payment = Mollie::api()->payments()->get($paymentId);
				Log::info($payment);
			} catch( Mollie_API_Exception $ex )
			{
				Log::error($ex->getMessage());
			}

		});
	});

	Route::group([ 'middleware' => [ 'auth' ], 'prefix' => 'checkout' ], function ()
	{
		Route::get('success', 'CheckoutController@getSuccess');
		Route::get('success-giftcard/{token}', 'CheckoutController@getSuccessNonSubscription');
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
		Route::post('settings/basic', 'AccountController@postSettingsBasic');

		Route::get('settings/subscription', 'AccountController@getSettingsSubscription');
		Route::post('settings/subscription/snooze', 'AccountController@postSettingsSubscriptionSnooze');
		Route::get('settings/subscription/start', 'AccountController@getSettingsSubscriptionStart');
		Route::get('settings/subscription/cancel', 'AccountController@getSettingsSubscriptionCancel');
		Route::get('settings/subscription/restart', 'AccountController@getSettingsSubscriptionRestart');

		Route::get('settings/billing', 'AccountController@getSettingsBilling');
		Route::get('settings/billing/delete', 'AccountController@getSettingsBillingRemove');
		Route::get('settings/billing/add', 'AccountController@getSettingsBillingAdd');
		Route::post('settings/billing/add', 'AccountController@postSettingsBillingAdd');
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

		Route::any('upload/image', function (\Illuminate\Http\Request $request)
		{
			if ( $request->hasFile('upload') )
			{
				/** @var \Illuminate\Http\UploadedFile $file */
				$file = $request->file('upload');
				if ( $file->isValid() )
				{
					$imgPath = public_path('uploads/cms/images/');
					$imgName = str_random(40) . '.' . $file->getClientOriginalExtension();

					$fileIsUnique = false;
					while( !$fileIsUnique )
					{
						if ( \File::exists("$imgPath/$imgName") )
						{
							$imgName = str_random(40) . '.' . $file->getClientOriginalExtension();
						}
						else
						{
							$fileIsUnique = true;
						}
					}

					$file->move($imgPath, $imgName);

					return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(" . $request->get('CKEditorFuncNum') . ", '" . ('/uploads/cms/images/' . $imgName) . "', '');</script>";
				}
			}
		});
	});

	Route::group([ 'middleware' => 'ajax' ], function ()
	{
		Route::post('call-me', function (\Illuminate\Http\Request $request)
		{
			$validator = Validator::make($request, [
				'phone'  => 'required',
				'period' => 'required'
			]);

			if ( $validator->fails() )
			{
				return Response::json([ 'messages' => $validator->messages() ], 403);
			}


			\App\Call::create([
				'phone'  => $request->get('phone'),
				'period' => $request->get('period'),
				'status' => 'requested'
			]);

			return Response::json([ 'message' => 'Tak, vi ringer til dig snarest!' ]); // todo translate
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
