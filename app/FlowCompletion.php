<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowCompletion extends Model
{
	protected $fillable = [
		'token',
		'user_data'
	];
}
