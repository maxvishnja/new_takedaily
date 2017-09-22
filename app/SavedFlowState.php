<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedFlowState extends Model
{
	protected $fillable = [
		'token',
		'user_data',
		'step',
		'sub_step',
	];
}
