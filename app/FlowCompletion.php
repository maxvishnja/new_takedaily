<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowCompletion extends Model
{
	protected $fillable = [
		'token',
		'user_data'
	];

	public function getUserDataAttribute($userData)
	{
		return json_decode($userData);
	}

	public static function generateNew($userData)
	{
		$token = str_random( 16 );

		while ( self::whereToken( $token )->limit( 1 )->count() > 0 )
		{
			$token = str_random( 16 );
		}

		return self::create( [
			'token'     => $token,
			'user_data' => $userData
		] );
	}
}
