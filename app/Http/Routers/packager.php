<?php
Route::group( [ 'prefix' => 'packaging', 'middleware' => ['packer', 'setLocale']], function ()
{
	view()->composer( 'packer.sidebar', function ( $view )
	{
		$orderRepo = new \App\Apricot\Repositories\OrderRepository();
		$view->with( ['sidebar_numOrders' => $orderRepo->getPaid()->shippable()
		                                            ->count(),
			'printed_numOrders' => $orderRepo->getPrinted()->count()]

			);
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
			                                 ->count(),

		] );
	} );

	Route::resource( 'orders', 'Packer\OrderController' );
	Route::get( 'orders/mark-sent/{id}', 'Packer\OrderController@markSent' );
	Route::get( 'orders/download/{id}', 'Packer\OrderController@print' );
	Route::get( 'download', 'Packer\OrderController@printAll' );
	Route::get( 'ship', 'Packer\OrderController@shipAll' );
	Route::get( 'printed-orders', 'Packer\OrderController@printed' );
	Route::get( 'shipped-orders', 'Packer\OrderController@sent' );
	Route::post( 'orders/handle-multiple', 'Packer\OrderController@handleMultiple' );
    Route::post( 'get-barcode', ['as' => 'barcode', 'uses' => 'Packer\OrderController@getBarcodeDK'] );
    Route::post( 'cancel-delivery', ['as' => 'cancel-delivery', 'uses' => 'Packer\OrderController@cancelDeliveryDK'] );
    Route::post( 'get-all-barcode-dk',  ['as' => 'get-all-barcode-dk', 'uses' => 'Packer\OrderController@getAllBarcodeDK'] );
} );