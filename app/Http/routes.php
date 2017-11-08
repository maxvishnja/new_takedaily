<?php

Route::group( [ 'middleware' => 'web' ], function ()
{
	/*
	 * Dashboard
	 */
	require_once 'Routers/dashboard.php';

	/*
	 * Packer
	 */
	require_once 'Routers/packager.php';

	/*
	 * Frontend routes
	 */
	Route::group( [ 'middleware' => 'setLocale' ], function ()
	{
		/*
		 * Auth
		 */
		require_once 'Routers/auth.php';

		/*
		 * Main routes
		 */
		Route::get( '/', 'HomeController@index' )->name( 'home' );

		Route::get('/privacy', function(){
		    return view('privacy');
        });


		Route::get( '/our-products', function ()
		{
			return view( 'quality');
		} )->name( 'our-products' );

		Route::get( '/how-it-works', function ()
		{
			return view( 'how-works');
		} )->name( 'how-it-works' );

		Route::get( '/about-us', function ()
		{
			return view( 'about');
		} )->name( 'about-us' );

		Route::get( '/faq', function ()
		{
			$faqs = ( new \App\Apricot\Repositories\FaqRepository() )->get();

			return view( 'faq.home', compact( 'faqs' ) );
		} )->name( 'faq' );

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



		Route::get( '/campaign/{code}', 'CampaignController@getCampaign')->name( 'campaign' );

		Route::get('/checksnooz/{hash}/{id}/{email}','SnoozingController@checkSnooz')->name('check_snooz');
		Route::post( 'orders/send-receipt', 'RecieptController@sendReciept' );
		Route::get( 'orders/down-receipt/{id}', 'RecieptController@downloadReciept' );


		/*
		 * Pick n mix
		 */
		require_once 'Routers/pick.php';

		/*
		 * Cart
		 */
		require_once 'Routers/cart.php';

		/*
		 * Flow
		 */
		require_once 'Routers/flow.php';

		/*
		 * Giftcard
		 */
		require_once 'Routers/gifting.php';

		/*
		 * Checkout
		 */
		require_once 'Routers/checkout.php';

		/*
		 * Account routes
		 */
		require_once 'Routers/account.php';

		/*
		 * Feedback routes
		 */
		require_once 'Routers/feedback.php';

		/*
		 * Extra ajax
		 */
		require_once 'Routers/ajax.php';

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

			if($identifier == 'a-zink') {
			    return view('page', compact('page'));
            }

			return view( 'page2', [
				'page' => $page,
			] );
		} );

	} );
} );
