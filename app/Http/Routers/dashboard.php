<?php
Route::group( [ 'prefix' => 'dashboard', 'middleware' => 'admin' ], function ()
{
	view()->composer( 'admin.sidebar', function ( $view )
	{
		$orderRepo = new \App\Apricot\Repositories\OrderRepository();
		$view->with( 'sidebar_numOrders', $orderRepo->getOpenOrder()
		                                            ->count() );

		$callRepo = new \App\Apricot\Repositories\CallRepository();
		$view->with( 'sidebar_numCalls', $callRepo->getRequests()
		                                          ->count() );

		$count_errors = \App\PaymentsError::where('check','=',0)->count();
		$view->with( 'sidebar_payErrors', $count_errors );
	} );

	Route::get( 'login', 'Auth\DashboardAuthController@showLoginForm' );
	Route::post( 'login', 'Auth\DashboardAuthController@login' );

	Route::get( '/', function ()
	{
		$orderRepo    = new \App\Apricot\Repositories\OrderRepository();
		$customerRepo = new \App\Apricot\Repositories\CustomerRepository();

		$salesYear     = $orderRepo->getMonthlySales();
		$orderYear     = $orderRepo->getMonthlyOrder();
		$orderMoneyYear     = $orderRepo->getMonthlyMoneyOrder();
		$customersYear = $customerRepo->getMonthlyNew();
		$customersDay = $customerRepo->getDailyNew();
		$customersUnsub = $customerRepo->getDailyUnsub();


		$activeNL = $customerRepo->allActiveLocale('EUR');
		$activePickNL = $customerRepo->allActivePickLocale('EUR');
		$activeDK = $customerRepo->allActiveLocale('DKK');
		$activePickDK = $customerRepo->allActivePickLocale('DKK');


		$churnDay = $customerRepo->churnDay();
		$churnPickDay = $customerRepo->churnPickDay();

		$money_today_dk = $orderRepo->getToday()
			->whereNotIn( 'state', [ 'new', 'cancelled' ] )
			->where( 'currency', 'DKK' )
			->sum( 'total' ) ?: 0;
		$money_today_nl = $orderRepo->getToday()
			->whereNotIn( 'state', [ 'new', 'cancelled' ] )
			->where( 'currency', 'EUR' )
			->sum( 'total' ) ?: 0;

		$money_today = $money_today_nl + $money_today_dk/7.45;
		return view( 'admin.home', [
			'orders_today'    => $orderRepo->getToday()
			                               ->count() ?: 0,
            'orders_pick_today'    => $orderRepo->getPickToday(),
			'customers_today' => $customerRepo->getToday()
			                                  ->count() ?: 0,
            'customers_pick_today' => $customerRepo->getPickToday(),
			'money_today'     => $money_today,
			'sales_year'      => $salesYear ?: [],
			'orderYear'      => $orderYear ?: [],
			'orderMoneyYear'      => $orderMoneyYear ?: [],
			'customers_year'  => $customersYear ?: [],
			'customers_day'  => $customersDay ?: [],
			'customers_unsub'  => $customersUnsub ?: [],
			'churnDay' => $churnDay,
			'churnPickDay' => $churnPickDay,
			'activeNL' => $activeNL,
			'activePickNL' => $activePickNL,
			'activeDK' => $activeDK,
			'activePickDK' => $activePickDK,
		] );
	} );

	Route::resource( 'customers', 'Dashboard\CustomerController' );
	Route::resource( 'campaign', 'Dashboard\CampaignController' );
	Route::get( 'customers/newpass/{id}', 'Dashboard\CustomerController@newPass' );
	Route::get( 'customers/bill/{id}', 'Dashboard\CustomerController@bill' );
	Route::get( 'customers/repeat/{id}', 'Dashboard\CustomerController@repeat' );
	Route::post( 'customers/cancel', 'Dashboard\CustomerController@cancel' );
	Route::get( 'customers/delete/{id}', 'Dashboard\CustomerController@destroy' );
	Route::post( 'customers/addnote/{id}', 'Dashboard\CustomerController@addNote' );

	Route::post( 'customers/find', ['as' => 'find-customer', 'uses' => 'Dashboard\CustomerController@findData'] );

	Route::resource( 'calls', 'Dashboard\CallController' );
	Route::get( 'calls/mark-done/{id}', 'Dashboard\CallController@markDone' );

	Route::resource( 'rewrites', 'Dashboard\RewriteController' );
	Route::get( 'almost', 'Dashboard\AlmostCustomersController@index' );
	Route::get( 'almost/delete/{id}', 'Dashboard\AlmostCustomersController@destroy' );
	Route::get( 'almost/send-all', 'Dashboard\AlmostCustomersController@sendAll' );
	Route::get( 'almost/send/{id}', 'Dashboard\AlmostCustomersController@sendOne' );
	Route::get( 'almost/csv', 'Dashboard\AlmostCustomersController@getCsv' );
	Route::get( 'rewrites/remove/{id}', 'Dashboard\RewriteController@remove' );

	Route::resource( 'reviews', 'Dashboard\ReviewsController');

    Route::get( 'orders/createNl', 'Dashboard\OrderController@createCsvNl' );
    Route::get( 'orders/createDk', 'Dashboard\OrderController@createCsvDk' );

	Route::resource( 'orders', 'Dashboard\OrderController' );
	Route::get( 'orders/mark-sent/{id}', 'Dashboard\OrderController@markSent' );
	Route::get( 'orders/refund/{id}', 'Dashboard\OrderController@refund' );
	Route::get( 'orders/download/{id}', 'Dashboard\OrderController@download' );

	Route::get( 'orders/download-sticker/{id}', 'Dashboard\OrderController@downloadSticker' );
	Route::resource( 'coupons', 'Dashboard\CouponController' );
	Route::resource( 'settings', 'Dashboard\SettingController' );
	Route::resource( 'products', 'Dashboard\ProductController' );
	Route::resource( 'vitamins', 'Dashboard\VitaminController' );
	Route::resource( 'pages', 'Dashboard\PageController' );
	Route::resource( 'page-translations', 'Dashboard\PageTranslationController' );
	Route::get( 'page-translations/{id}/delete', 'Dashboard\PageTranslationController@delete' );

    // Stock / Inventory
    Route::get('/stock', 'Stock\StockController@index');
    Route::get('/stock/new', 'Stock\StockController@create');
    Route::get('/stock/edit/{id}', 'Stock\StockController@edit');
    Route::get('/stock/delete/{id}', 'Stock\StockController@delete');
    Route::post('/stock', 'Stock\StockController@insert');
    Route::post('/stock-update', 'Stock\StockController@update');

	Route::resource( 'faq', 'Dashboard\FaqController' );
	Route::get( 'payments-error', 'Dashboard\PaymentsErrorController@index' );
	Route::get( 'payments-error/check/{id}', 'Dashboard\PaymentsErrorController@check' );
	Route::get( 'snoozing', 'Dashboard\SnoozingController@index' );
	Route::get( 'sent-mails', 'Dashboard\SentMailsController@index' );
	Route::get( 'sent-mails/get-date', 'Dashboard\SentMailsController@getDate' );
	Route::get( 'stats', 'Dashboard\StatsController@index' );
	Route::post('stats/post', ['as' => 'stats-post', 'uses' => 'Dashboard\StatsController@getData']);
    Route::post('stats/coupon-post', ['as' => 'coupon-post', 'uses' => 'Dashboard\StatsController@getStatsCustomersFromCoupon']);
	Route::post('stats/exportdate', ['as' => 'csv-export', 'uses' => 'Dashboard\StatsController@exportCsvDate']);
	Route::post('stats/chortscsv', ['as' => 'cohorts-export', 'uses' => 'Dashboard\StatsController@cohortsToCsv']);
	Route::post('stats/export-coupon', ['as' => 'export-coupon', 'uses' => 'Dashboard\StatsController@exportDateCoupon']);
	Route::post('stats/export', ['as' => 'export', 'uses' => 'Dashboard\StatsController@exportCsv']);
	Route::post('stats/check-csv', ['as' => 'check', 'uses' => 'Dashboard\StatsController@checkCsv']);
	Route::post('stats/download', ['as' => 'check', 'uses' => 'Dashboard\StatsController@downloadCsv']);
    Route::post('stats/export_all_customers', ['as' => 'export', 'uses' => 'Dashboard\StatsController@exportCsvAllCustomers']);
    Route::post('stats/check-csv-all-customers', ['as' => 'check', 'uses' => 'Dashboard\StatsController@checkCsvAllCustomers']);
	Route::post('stats/download-all-customers', ['as' => 'check', 'uses' => 'Dashboard\StatsController@downloadCsvAllCustomers']);
	Route::post('stats/reason', ['as' => 'reason', 'uses' => 'Dashboard\StatsController@getUnsubscribeReason']);
	Route::resource( 'feedback', 'Dashboard\FeedbackController' );
	Route::get( 'feedback/delete/{id}', 'Dashboard\FeedbackController@destroy' );
	Route::resource( 'faq-translations', 'Dashboard\FaqTranslationController' );
	Route::get( 'faq-translations/{id}/delete', 'Dashboard\FaqTranslationController@delete' );
    Route::resource( 'nutritionist', 'Dashboard\NutritionistController' );
    Route::get( 'nutritionist/delete/{id}', 'Dashboard\NutritionistController@destroy' );


    Route::resource( 'actions', 'Dashboard\ActionsController' );
    
    
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