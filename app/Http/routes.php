<?php

Route::group( [ 'middleware' => 'web' ], function ()
{
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
				                               ->count() ?: 0,
				'customers_today' => $customerRepo->getToday()
				                                  ->count() ?: 0,
				'money_today'     => $orderRepo->getToday()
				                               ->whereNotIn( 'state', [ 'new', 'cancelled' ] )
				                               ->sum( 'total' ) ?: 0,
				'sales_year'      => $salesYear ?: [],
				'customers_year'  => $customersYear ?: []
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

		Route::resource( 'faq', 'Dashboard\FaqController' );
		Route::resource( 'faq-translations', 'Dashboard\FaqTranslationController' );
		Route::get( 'faq-translations/{id}/delete', 'Dashboard\FaqTranslationController@delete' );

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
			$view->with( 'sidebar_numOrders', $orderRepo->getPaid()->shippable()
			                                            ->count() );
		} );

		Route::get( 'login', 'Auth\PackerAuthController@showLoginForm' );
		Route::post( 'login', 'Auth\PackerAuthController@login' );

		Route::get( '/', function ()
		{
			$orderRepo = new \App\Apricot\Repositories\OrderRepository();

			return view( 'packer.home', [
				'orders_today'      => $orderRepo->getToday()->paid()->shippable()
				                                 ->count(),
				'sidebar_numOrders' => $orderRepo->getToday()->paid()->shippable()
				                                 ->count()
			] );
		} );

		Route::resource( 'orders', 'Packer\OrderController' );
		Route::get( 'orders/mark-sent/{id}', 'Packer\OrderController@markSent' );
		Route::get( 'orders/download/{id}', 'Packer\OrderController@print' );
		Route::get( 'download', 'Packer\OrderController@printAll' );
		Route::get( 'ship', 'Packer\OrderController@shipAll' );
		Route::post( 'orders/handle-multiple', 'Packer\OrderController@handleMultiple' );
	} );

	/*
	 * Frontend routes
	 */
	Route::group( [ 'middleware' => 'setLocale' ], function ()
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
			$faqs = ( new \App\Apricot\Repositories\FaqRepository() )->get();

			return view( 'home', compact( 'faqs' ) );
		} )->name( 'home' );

		Route::get( '/faq', function ()
		{
			$faqs = ( new \App\Apricot\Repositories\FaqRepository() )->get();

			return view( 'faq.home', compact( 'faqs' ) );
		} )->name( 'faq' );

		Route::get( '/use-giftcard', function ()
		{
			return view( 'use-giftcard' );
		} );

		Route::post( '/use-giftcard', function ( \Illuminate\Http\Request $request )
		{
			$validator = Validator::make( $request->all(), [
				'giftcard_code' => 'required|exists:giftcards,token'
			] );

			if ( $validator->fails() )
			{
				return redirect()->back()->withErrors( $validator->messages() );
			}

			$giftcard = \App\Giftcard::whereToken( $request->get( 'giftcard_code' ) )->whereIsUsed( 0 )->first();

			if ( ! $giftcard )
			{
				return redirect()->back()->withErrors( [ trans( 'use-gifting.failed' ) ] );
			}

			Session::put( 'giftcard_id', $giftcard->id );
			Session::put( 'giftcard_token', $giftcard->token );

			return Redirect::route( 'flow' )->with( 'success', trans( 'use-gifting.success' ) );
		} )->name( 'use-giftcard-post' );

		Route::get( '/faq/{identifier}', function ( $identifier )
		{
			$repo = new \App\Apricot\Repositories\FaqRepository;

			$faq = $repo->findByIdentifier( $identifier );

			if ( ! $faq )
			{
				abort( 404 );
			}

			return view( 'faq.view', compact( $faq ) );
		} );

		Route::get( 'pick-n-mix', 'PickMixController@get' )->name( 'pick-n-mix' );
		Route::post( 'pick-n-mix', 'PickMixController@post' )->name( 'pick-n-mix-post' );

		Route::get( 'pick-package', 'PackageController@get' )->name( 'pick-package' );
		Route::get( 'pick-package/select/{id}', 'PackageController@select' )->name( 'pick-package-select' );
		Route::post( 'pick-package', 'PackageController@post' )->name( 'pick-package-post' );

		Route::get( '/cart', function ()
		{
			// Generate lines
			$lines = \App\Apricot\Checkout\Cart::get()->map( function ( $item )
			{
				if ( Lang::has( "products.{$item->name}" ) )
				{
					$item->name = trans( "products.{$item->name}" );
				}
				else
				{
					$item->hidePrice = true;
				}

				$item->amount = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat( $item->amount );

				return $item;
			} );

			// Get coupon
			$couponData = [];
			if ( \Session::has( 'applied_coupon' ) )
			{
				$couponRepository = new \App\Apricot\Repositories\CouponRepository();
				/** @var \App\Coupon|null $coupon */
				$coupon = $couponRepository->findByCoupon( \Session::get( 'applied_coupon' ) );

				if ( $coupon )
				{
					$couponData = [
						'applied'     => true,
						'type'        => $coupon->discount_type,
						'amount'      => $coupon->discount,
						'applies_to'  => $coupon->applies_to,
						'description' => $coupon->description,
						'code'        => $coupon->code
					];
				}
			}


			// Get giftcard
			$giftcardData = [];
			if ( \Session::has( 'giftcard_id' ) && \Session::has( 'giftcard_token' ) && \Session::get( 'product_name', 'subscription' ) == 'subscription' )
			{
				$giftcard = \App\Giftcard::where( 'id', \Session::get( 'giftcard_id' ) )
				                         ->where( 'token', \Session::get( 'giftcard_token' ) )
				                         ->where( 'is_used', 0 )
				                         ->first();

				if ( $giftcard )
				{
					$giftcardData = [
						'worth' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($giftcard->worth)
					];
				}
			}

			return Response::json( [ 'lines' => $lines, 'info' => \App\Apricot\Checkout\Cart::getInfo(), 'coupon' => $couponData, 'giftcard' => $giftcardData ] );
		} );

		Route::post( '/cart-deduct/{vitaminGroup}', function ( $vitaminGroup )
		{
			switch ( $vitaminGroup )
			{
				case 1:
				case 'one':
					$vitaminGroup = 1;
					break;

				case 2:
				case 'two':
					$vitaminGroup = 2;
					break;

				default:
				case 3:
				case 'three':
				case 'four':
				case 'five':
					$vitaminGroup = 3;
					break;
			}


			if ( \App\Apricot\Checkout\Cart::hasInfo( "vitamins.{$vitaminGroup}" ) )
			{
				\App\Apricot\Checkout\Cart::deductProduct( 'vitamin' );
				\App\Apricot\Checkout\Cart::removeProduct( "vitamin.{$vitaminGroup}" );
				\App\Apricot\Checkout\Cart::removeInfo( "vitamins.{$vitaminGroup}" );
			}

			return Response::json( [ 'message' => 'Ok' ] );
		} );

		Route::get( '/flow', function ( \Illuminate\Http\Request $request )
		{
			$giftcard = null;

			if ( \Session::has( 'giftcard_id' ) && \Session::has( 'giftcard_token' ) && \Session::get( 'product_name', 'subscription' ) == 'subscription' )
			{
				$giftcard = \App\Giftcard::where( 'id', \Session::get( 'giftcard_id' ) )
				                         ->where( 'token', \Session::get( 'giftcard_token' ) )
				                         ->where( 'is_used', 0 )
				                         ->first();
			}

			$product = \App\Product::whereName( 'subscription' )
			                       ->first();

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

			$userData = [];
			$delay    = 3200;

			if ( $request->has( 'token' ) )
			{
				$flowCompletion = \App\FlowCompletion::whereToken( $request->get( 'token' ) )->first();

				if ( $flowCompletion )
				{
					$userData = $flowCompletion->user_data;
					$delay    = 0;
				}
			}

			return view( 'flow', compact( 'giftcard', 'coupon', 'product', 'taxRate', 'shippingPrice', 'userData', 'delay' ) );
		} )->name( 'flow' );

		Route::post( 'flow/send-recommendation', function ( \Illuminate\Http\Request $request )
		{
			// todo validate has email and token
			$to = $request->get( 'email' );

			Mail::queue( 'emails.recommendation', [ 'locale' => App::getLocale(), 'token' => $request->get( 'token' ) ], function ( \Illuminate\Mail\Message $message ) use ( $to )
			{
				$message->to( $to );
				$message->subject( trans( 'mails.recommendation.subject' ) );
			} );

			return Response::json( [ 'message' => 'mail added to queue' ] );
		} )->name( 'send-flow-recommendations' );

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

			$token = str_random( 16 );

			while ( \App\FlowCompletion::whereToken( $token )->limit( 1 )->count() > 0 )
			{
				$token = str_random( 16 );
			}

			$flowCompletion = \App\FlowCompletion::create( [
				'token'     => $token,
				'user_data' => $request->get( 'user_data', '{}' )
			] );

			$request->session()->set( 'flow-completion-token', $flowCompletion->token );

			$ingredients = '';
			$alphabet    = range( 'a', 'c' );

			\App\Apricot\Checkout\Cart::clear();
			\App\Apricot\Checkout\Cart::addProduct( 'subscription' );
			\App\Apricot\Checkout\Cart::addProduct( 'shipping', 0 );

			foreach ( $lib->getResult() as $index => $combination )
			{
				$combinationKey = $combination;
				$indexOld       = $index;

				if ( $index == 'one' )
				{
					$combination = $alphabet[ $combination - 1 ];
				}

				switch ( $index )
				{
					case 'one':
						$index = 1;
						break;
					case 'two':
						$index = 2;
						break;
					case 'three':
					default:
						$index = 3;
						break;
				}

				$ingredients .= '<div class="ingredient_item" data-item="' . $index . $combination . '">
					<h3>' . trans( strtolower( "label-{$index}{$combination}.name" ) ) . '</h3>
					' . view('flow-includes.views.vitamin_table', ['label' => "{$index}{$combination}" ]) . '
				</div>';

				$vitamin_code = \App\Apricot\Libraries\PillLibrary::getPill( $indexOld, $combinationKey );
				\App\Apricot\Checkout\Cart::addProduct( \App\Apricot\Libraries\PillLibrary::$codes[ $vitamin_code ], '', [ 'key' => "vitamin.{$index}" ] );
				\App\Apricot\Checkout\Cart::addInfo( "vitamins.{$index}", $vitamin_code );
			}

			$lib = new \App\Apricot\Libraries\CombinationLibrary();
			$lib->generateResult( json_decode( $request->get( 'user_data' ) ) );
			\App\Apricot\Checkout\Cart::addInfo( "user_data", json_decode( $request->get( 'user_data' ) ) );

			return Response::json( [
				'advises'        => $advises,
				'num_advises'    => count( $lib->getAdvises() ),
				'label'          => view( 'flow-label', [ 'combinations' => $lib->getResult(), 'advises' => $lib->getAdviseInfos() ] )->render(),
				'selected_codes' => implode( ',', $codes ),
				'result'         => $lib->getResult(),
				'vitamin_info'   => $ingredients,
				'token'          => $flowCompletion->token
			] );
		} )->name( 'flow-recommendations' );

		Route::post( 'flow', function ( \Illuminate\Http\Request $request )
		{
			$userData = json_decode( $request->get( 'user_data' ) );

			if ( Auth::check() && Auth::user()->isUser() )
			{

				$combinations = Auth::user()->getCustomer()->calculateCombinations();
				$vitamins     = [];

				foreach ( $combinations as $key => $combination )
				{
					$pill    = \App\Apricot\Libraries\PillLibrary::getPill( $key, $combination );
					$vitamin = \App\Vitamin::select( 'id' )->whereCode( $pill )->first();

					if ( $vitamin )
					{
						$vitamins[] = $vitamin->id;
					}
				}

				Auth::user()->getCustomer()->unsetCustomUserdata();
				Auth::user()->getCustomer()->updateUserdata( $userData );
				Auth::user()->getCustomer()->getPlan()->setIsCustom( false );
				Auth::user()->getCustomer()->setVitamins( $vitamins );

				return \Redirect::action( 'AccountController@getSettingsSubscription' )
				                ->with( 'success', 'Din pakke blev opdateret!' ); // todo translate
			}
			else
			{
				if ( Auth::check() && ! Auth::user()->isUser() )
				{
					Auth::logout();
				}

				Session::forget( 'vitamins' );
				Session::forget( 'package' );
				Session::put( 'user_data', $userData );
				Session::put( 'product_name', $request->get( 'product_name' ) );
				Session::put( 'flow-completion-token', $request->get( 'flow-token' ) );

				return Redirect::action( 'CheckoutController@getCheckout' );
			}
		} )->name( 'flow-post' );

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
			Session::forget( 'flow-completion-token' );

			return Redirect::to( '/flow' );
		} )->name( 'flow-upsell' );

		Route::get( 'gifting', function ()
		{
			\Session::forget( 'user_data' );
			\Session::forget( 'flow-completion-token' );
			\Session::forget( 'vitamins' );

			return view( 'gifting' );
		} )->name( 'gifting' );

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
			Route::get( 'verify/{method}', 'CheckoutController@getVerify' )->name( 'checkout-verify-method' );

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

			} )->name( 'checkout-webhook-mollie' );
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

			Route::get( '/', function ()
			{
				return redirect()->action( 'AccountController@getSettingsBasic' );
			} );
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
					'period' => 'required',
					'date'   => 'required'
				] );

				if ( $validator->fails() )
				{
					return Response::json( [ 'messages' => $validator->messages() ], 403 );
				}


				\App\Call::create( [
					'phone'   => $request->get( 'phone' ),
					'period'  => $request->get( 'period' ),
					'call_at' => $request->get( 'date' ),
					'status'  => 'requested'
				] );

				return Response::json( [ 'message' => trans( 'flow.call-me.success' ) ] );
			} )->name( 'ajax-call-me' );
		} );

		/*
		 * CMS dynamic routing
		 */
		Route::get( 'page/{identifier}', function ( $identifier )
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
} );
