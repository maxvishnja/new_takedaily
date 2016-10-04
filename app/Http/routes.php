<?php

Route::group( [ 'middleware' => 'web' ], function ()
{
	Route::group( [ 'prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ] ], function ()
	{
		/*
		 * Auth routes
		 */
		Route::get( 'login', 'Auth\AuthController@showLoginForm' );
		Route::post( 'login', 'Auth\AuthController@login' );
		Route::get( 'logout', 'Auth\AuthController@logout' );

		// Password Reset Routes...
		Route::get( 'password/reset/{token?}', 'Auth\PasswordController@showResetForm' );
		Route::post( 'password/email', 'Auth\PasswordController@sendResetLinkEmail' );
		Route::post( 'password/reset', 'Auth\PasswordController@reset' );

		/*
		 * Main routes
		 */
		Route::get( '/', function ()
		{
			return view( 'home' );
		} );

		Route::group( [ 'middleware' => [ 'nonAdmin' ] ], function ()
		{
			Route::get( 'pick-n-mix', 'PickMixController@get' );
			Route::post( 'pick-n-mix', 'PickMixController@post' );

			Route::get( 'flow', function ()
			{
				$giftcard = null;

				if ( \Session::has( 'giftcard_id' ) && \Session::has( 'giftcard_token' ) && \Session::get( 'product_name', 'subscription' ) == 'subscription' )
				{
					$giftcard = \App\Giftcard::where( 'id', \Session::get( 'giftcard_id' ) )
					                         ->where( 'token', \Session::get( 'giftcard_token' ) )
					                         ->where( 'is_used', 0 )
					                         ->first();
				}

				if ( Auth::user() && Auth::user()
				                         ->getCustomer()
				)
				{
					return redirect( '/pick-n-mix' )->with( 'warning', 'Du har allerede en konto, du kan ændre dine vitaminer eller logge ud og oprette en ny konto.' ); // todo translate
				}

				$product = \App\Product::whereName( 'subscription' )
				                       ->first();

				// todo fixme giftcard is not taken into consideration

				// Coupon
				$coupon = null;
				if ( \Session::has( 'applied_coupon' ) )
				{
					$couponRepository = new \App\Apricot\Repositories\CouponRepository();
					$coupon           = $couponRepository->findByCoupon( \Session::get( 'applied_coupon' ) );
				}

				$zone          = new \App\Apricot\Libraries\TaxLibrary( trans( 'general.tax_zone' ) );
				$taxRate       = $zone->rate();
				$shippingPrice = \App\Setting::getWithDefault( 'shipping_price', 0 );

				return view( 'flow', compact( 'giftcard', 'coupon', 'product', 'taxRate', 'shippingPrice' ) );
			} );

			Route::post( 'flow/recommendations', function ( \Illuminate\Http\Request $request )
			{
				$lib = new \App\Apricot\Libraries\CombinationLibrary();

				$lib->generateResult( json_decode( $request->get( 'user_data' ) ) );

				$advises = '';

				foreach ( $lib->getAdvises() as $adviseKey => $advise )
				{
					$advises .= '<p>' . $advise . '</p>';
				}

				$codes = [];

				foreach ( $lib->getResult() as $combKey => $combVal )
				{
					$codes[] = \App\Apricot\Libraries\PillLibrary::getPill( $combKey, $combVal );
				}


				return Response::json( [
					'advises'        => $advises,
					'num_advises'    => count( $lib->getAdvises() ),
					'label'          => view( 'flow-label', [ 'combinations' => $lib->getResult(), 'advises' => $lib->getAdviseInfos() ] )->render(),
					'selected_codes' => implode( ',', $codes )
				] );
			} );
		} );

		Route::post( 'flow', function ( \Illuminate\Http\Request $request )
		{
			$userData = json_decode( $request->get( 'user_data' ) );

			Session::put( 'user_data', $userData );
			Session::put( 'product_name', $request->get( 'product_name' ) );

			return Redirect::action( 'CheckoutController@getCheckout' );
		} );

		Route::post( 'flow-upsell', function ( \Illuminate\Http\Request $request )
		{
			if ( ! $request->get( 'upsell_token' ) == Session::get( 'upsell_token' ) || ! Session::has( 'upsell_token' ) )
			{
				return Redirect::to( '/flow' );
			}

			\Auth::logout();

			$coupon = \App\Coupon::create( [
				'description'   => 'Upsell discount',
				'code'          => str_random( 8 ),
				'discount'      => 50,
				'applies_to'    => 'order',
				'discount_type' => 'percentage',
				'uses_left'     => 1,
				'valid_from'    => \Jenssegers\Date\Date::now(),
				'valid_to'      => \Jenssegers\Date\Date::now()
				                                        ->addDay()
			] );

			Session::put( 'applied_coupon', $coupon->code );

			return Redirect::to( '/flow' );
		} );

		Route::get( 'gifting', function ()
		{
			return view( 'gifting' );
		} );

		/*
		 * Signup
		 */
		Route::get( 'gc/{token}', function ( $token, \Illuminate\Http\Request $request )
		{
			$giftcard = \App\Giftcard::where( 'token', $token )
			                         ->where( 'is_used', 0 )
			                         ->first();

			if ( ! $giftcard )
			{
				abort( 404 );
			}

			$request->session()
			        ->put( 'giftcard_id', $giftcard->id );
			$request->session()
			        ->put( 'giftcard_token', $giftcard->token );

			return Redirect::to( 'flow' )
			               ->with( 'success', trans( 'message.success.giftcard-applied' ) );
		} );

		/*
		 * Checkout
		 */
		Route::group( [ 'middleware' => [ 'secure' ], 'prefix' => 'checkout' ], function ()
		{
			Route::get( '', 'CheckoutController@getCheckout' );
			Route::post( '', 'CheckoutController@postCheckout' );
			Route::post( 'apply-coupon', 'CheckoutController@applyCoupon' );
			Route::get( 'get-taxrate', 'CheckoutController@getTaxRate' );

			// Charge verify
			Route::get( 'verify/{method}', 'CheckoutController@getVerify' );

			// Mollie webhook
			Route::post( 'mollie', function ( $paymentId = 0 )
			{
				try
				{
					$payment = Mollie::api()
					                 ->payments()
					                 ->get( $paymentId );
					Log::info( $payment ); // todo make this work......
				} catch ( Mollie_API_Exception $ex )
				{
					Log::error( $ex->getMessage() );
				}

			} );
		} );

		Route::group( [ 'prefix' => 'checkout' ], function ()
		{
			Route::get( 'success', 'CheckoutController@getSuccess' );
			Route::get( 'success-giftcard/{token}', 'CheckoutController@getSuccessNonSubscription' );
		} );

		/*
		 * Account routes
		 */
		Route::group( [ 'middleware' => [ 'auth', 'user' ], 'prefix' => 'account' ], function ()
		{
			Route::get( 'settings', function ()
			{
				// Redirect to the correct route (../basic)
				return redirect( 'account/settings/basic' );
			} );

			Route::get( '/', 'AccountController@getHome' );
			Route::post( '/update-preferences', 'AccountController@updatePreferences' );

			Route::get( 'transactions', 'AccountController@getTransactions' );
			Route::get( 'transactions/{id}', 'AccountController@getTransaction' );

			Route::get( 'settings/basic', 'AccountController@getSettingsBasic' );
			Route::post( 'settings/basic', 'AccountController@postSettingsBasic' );

			Route::get( 'settings/update-vitamins', 'AccountController@updateVitamins' );

			Route::get( 'settings/subscription', 'AccountController@getSettingsSubscription' );
			Route::post( 'settings/subscription/snooze', 'AccountController@postSettingsSubscriptionSnooze' );
			Route::get( 'settings/subscription/start', 'AccountController@getSettingsSubscriptionStart' );
			Route::get( 'settings/subscription/cancel', 'AccountController@getSettingsSubscriptionCancel' );
			Route::get( 'settings/subscription/restart', 'AccountController@getSettingsSubscriptionRestart' );

			Route::get( 'settings/billing', 'AccountController@getSettingsBilling' );
			Route::get( 'settings/billing/delete', 'AccountController@getSettingsBillingRemove' );
			Route::get( 'settings/billing/add', 'AccountController@getSettingsBillingAdd' );
			Route::post( 'settings/billing/add', 'AccountController@postSettingsBillingAdd' );
		} );


		Route::group( [ 'middleware' => 'ajax' ], function ()
		{
			Route::post( 'call-me', function ( \Illuminate\Http\Request $request )
			{
				$validator = Validator::make( $request->all(), [
					'phone'  => 'required',
					'period' => 'required'
				] );

				if ( $validator->fails() )
				{
					return Response::json( [ 'messages' => $validator->messages() ], 403 );
				}


				\App\Call::create( [
					'phone'  => $request->get( 'phone' ),
					'period' => $request->get( 'period' ),
					'status' => 'requested'
				] );

				return Response::json( [ 'message' => 'Tak, vi ringer til dig snarest!' ] ); // todo translate
			} );
		} );

		/*
		 * CMS dynamic routing
		 */
		Route::get( '{identifier}', function ( $identifier )
		{
			$repo = new \App\Apricot\Repositories\PageRepository();
			$page = $repo->findByIdentifier( $identifier )
			             ->first();

			if ( ! $page )
			{
				abort( 404 );
			}

			$translation = $page->translations()
			                    ->whereLocale( App::getLocale() )
			                    ->first();

			if ( $translation )
			{
				$page->title            = $translation->title;
				$page->sub_title        = $translation->sub_title;
				$page->body             = $translation->body;
				$page->meta_image       = $translation->meta_image;
				$page->meta_title       = $translation->meta_title;
				$page->meta_description = $translation->meta_description;
			}

			return view( 'page', [
				'page' => $page
			] );
		} );

	} );
	/*
	 * Dashboard routes
	 */
	Route::group( [ 'prefix' => 'dashboard', 'middleware' => 'admin' ], function ()
	{
		view()->composer( 'admin.sidebar', function ( $view )
		{
			$orderRepo = new \App\Apricot\Repositories\OrderRepository();
			$view->with( 'sidebar_numOrders', $orderRepo->getNotShipped()
			                                            ->count() );

			$callRepo = new \App\Apricot\Repositories\CallRepository();
			$view->with( 'sidebar_numCalls', $callRepo->getRequests()
			                                          ->count() );
		} );

		Route::get( 'login', 'Auth\DashboardAuthController@showLoginForm' );
		Route::post( 'login', 'Auth\DashboardAuthController@login' );

		Route::get( '/', function ()
		{
			$orderRepo    = new \App\Apricot\Repositories\OrderRepository();
			$customerRepo = new \App\Apricot\Repositories\CustomerRepository();

			$salesYear     = $orderRepo->getMonthlySales();
			$customersYear = $customerRepo->getMonthlyNew();

			return view( 'admin.home', [
				'orders_today'    => $orderRepo->getToday()
				                               ->count(),
				'customers_today' => $customerRepo->getToday()
				                                  ->count(),
				'money_today'     => $orderRepo->getToday()
				                               ->whereNotIn( 'state', [ 'new', 'cancelled' ] )
				                               ->sum( 'total' ),
				'sales_year'      => $salesYear,
				'customers_year'  => $customersYear
			] );
		} );

		Route::resource( 'customers', 'Dashboard\CustomerController' );
		Route::get( 'customers/newpass/{id}', 'Dashboard\CustomerController@newPass' );
		Route::get( 'customers/bill/{id}', 'Dashboard\CustomerController@bill' );
		Route::get( 'customers/cancel/{id}', 'Dashboard\CustomerController@cancel' );

		Route::resource( 'calls', 'Dashboard\CallController' );
		Route::get( 'calls/mark-done/{id}', 'Dashboard\CallController@markDone' );

		Route::resource( 'rewrites', 'Dashboard\RewriteController' );
		Route::get( 'rewrites/remove/{id}', 'Dashboard\RewriteController@remove' );

		Route::resource( 'orders', 'Dashboard\OrderController' );
		Route::get( 'orders/mark-sent/{id}', 'Dashboard\OrderController@markSent' );
		Route::get( 'orders/refund/{id}', 'Dashboard\OrderController@refund' );
		Route::get( 'orders/download/{id}', 'Dashboard\OrderController@download' );
		Route::get( 'orders/download-sticker/{id}', 'Dashboard\OrderController@downloadSticker' );
		Route::resource( 'coupons', 'Dashboard\CouponController' );
		Route::resource( 'settings', 'Dashboard\SettingController' );
		Route::resource( 'products', 'Dashboard\ProductController' );
		Route::resource( 'pages', 'Dashboard\PageController' );
		Route::resource( 'page-translations', 'Dashboard\PageTranslationController' );
		Route::get( 'page-translations/{id}/delete', 'Dashboard\PageTranslationController@delete' );

		Route::any( 'upload/image', function ( \Illuminate\Http\Request $request )
		{
			if ( $request->hasFile( 'upload' ) )
			{
				/** @var \Illuminate\Http\UploadedFile $file */
				$file = $request->file( 'upload' );
				if ( $file->isValid() )
				{
					$imgPath = public_path( 'uploads/cms/images/' );
					$imgName = str_random( 40 ) . '.' . $file->getClientOriginalExtension();

					$fileIsUnique = false;
					while ( ! $fileIsUnique )
					{
						if ( \File::exists( "$imgPath/$imgName" ) )
						{
							$imgName = str_random( 40 ) . '.' . $file->getClientOriginalExtension();
						}
						else
						{
							$fileIsUnique = true;
						}
					}

					$file->move( $imgPath, $imgName );

					return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(" . $request->get( 'CKEditorFuncNum' ) . ", '" . ( '/uploads/cms/images/' . $imgName ) . "', '');</script>";
				}
			}
		} );
	} );

	/*
	 * Packer routes
	 */
	Route::group( [ 'prefix' => 'packaging', 'middleware' => 'packer' ], function ()
	{
		view()->composer( 'packer.sidebar', function ( $view )
		{
			$orderRepo = new \App\Apricot\Repositories\OrderRepository();
			$view->with( 'sidebar_numOrders', $orderRepo->getNotShipped()
			                                            ->count() );
		} );

		Route::get( 'login', 'Auth\PackerAuthController@showLoginForm' );
		Route::post( 'login', 'Auth\PackerAuthController@login' );

		Route::get( '/', function ()
		{
			$orderRepo = new \App\Apricot\Repositories\OrderRepository();

			return view( 'packer.home', [
				'orders_today'      => $orderRepo->getToday()
				                                 ->count(),
				'sidebar_numOrders' => $orderRepo->getNotShipped()
				                                 ->count()
			] );
		} );

		Route::resource( 'orders', 'Packer\OrderController' );
		Route::get( 'orders/mark-sent/{id}', 'Packer\OrderController@markSent' );
		Route::get( 'orders/download/{id}', 'Packer\OrderController@download' );
		Route::post( 'orders/handle-multiple', 'Packer\OrderController@handleMultiple' );
	} );
} );
