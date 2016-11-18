<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	protected $fillable = [
		'token',
	    'lines',
	    'extra_data'
	];

	public static function findByToken($token)
	{
		return self::whereToken($token)->first();
	}

	public function getLines()
	{
		return json_decode($this->lines);
	}
}
