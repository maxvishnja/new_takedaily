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

	public function generateIdentifier($title)
	{
		$title = trim($title, ' ');
		$title = strtolower($title);
		$title = preg_replace("/(å)/", 'aa', $title);
		$title = preg_replace("/(ø)/", 'oe', $title);
		$title = preg_replace("/(æ)/", 'ae', $title);
		$title = preg_replace("/\s\s+/", ' ', $title);
		$title = preg_replace("/( )/", '-', $title);
		$title = preg_replace("/([^a-z0-9-])/", '', $title);
		$title = preg_replace("/\-\-+/", '-', $title);
		$title = substr($title, 0, 50);

		return $title;
	}
}
