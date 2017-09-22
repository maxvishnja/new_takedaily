<?php

Route::get( 'feedback/{id}', 'FeedbackController@index' );
Route::get( 'feedback', 'FeedbackController@index' );
Route::post( 'feedback', ['as' => 'feed-add', 'uses' => 'FeedbackController@addFeedback'] );
