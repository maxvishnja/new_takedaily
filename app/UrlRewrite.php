<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlRewrite extends Model
{
	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'url_rewrites';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'requested_path',
		'actual_path',
		'redirect_type'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];
}
