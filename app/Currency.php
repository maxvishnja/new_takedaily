<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Currency extends Model
{
	use Rememberable;

	protected $fillable = [
		'name',
		'rate'
	];
}
