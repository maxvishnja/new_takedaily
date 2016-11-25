<?php
Route::group( [ 'middleware' => 'ajax' ], function ()
{
	Route::post( 'call-me', 'CallMeController@post' )->name( 'ajax-call-me' );
} );