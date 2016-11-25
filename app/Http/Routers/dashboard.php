<?php
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