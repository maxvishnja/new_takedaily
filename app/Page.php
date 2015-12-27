<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'pages';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'url_identifier',
		'title',
		'sub_title',
		'body',
		'meta_title',
		'meta_description',
		'meta_image'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];
}
