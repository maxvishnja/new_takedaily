<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giftcard extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'giftcards';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'token',
		'worth',
		'is_used'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];
}
