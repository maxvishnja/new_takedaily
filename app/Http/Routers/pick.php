<?php

Route::get( 'pick-n-mix', 'PickMixController@get' )->name( 'pick-n-mix' );
Route::post( 'pick-n-mix', 'PickMixController@post' )->name( 'pick-n-mix-post' );

Route::get( 'pick-package', 'PackageController@get' )->name( 'pick-package' );
Route::get( 'pick-package/select/{id}', 'PackageController@select' )->name( 'pick-package-select' );
Route::post( 'pick-package', 'PackageController@post' )->name( 'pick-package-post' );