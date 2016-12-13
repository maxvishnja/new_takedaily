<?php
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
	Route::get( 'settings/subscription/cancel-flow', 'AccountController@getCancelPage' );
	Route::post( 'settings/subscription/cancel', 'AccountController@getSettingsSubscriptionCancel' );
	Route::get( 'settings/subscription/restart', 'AccountController@getSettingsSubscriptionRestart' );

	Route::get( 'settings/billing', 'AccountController@getSettingsBilling' );
	Route::get( 'settings/billing/delete', 'AccountController@getSettingsBillingRemove' );
	Route::get( 'settings/billing/add', 'AccountController@getSettingsBillingAdd' );
	Route::post( 'settings/billing/add', 'AccountController@postSettingsBillingAdd' );
	Route::post( 'settings/billing/change', 'AccountController@updatePaymentMethod' );

	Route::get( '/see-recommendation', 'AccountController@getSeeRecommendation' );
} );