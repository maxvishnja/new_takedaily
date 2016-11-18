<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	public static function findByToken($token)
	{
		return self::whereToken($token)->first();
	}
}
