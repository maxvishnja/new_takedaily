<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'products';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'price',
		'is_subscription'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];
}
