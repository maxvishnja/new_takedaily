<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'supplements';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];
}
