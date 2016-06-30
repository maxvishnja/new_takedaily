<?php

namespace App;

use App\Apricot\Libraries\SlugLibrary;
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
		'meta_image',
		'is_locked'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];

	public function translations()
	{
		return $this->hasMany(PageTranslation::class);
	}

	public function generateIdentifier($title)
	{
		return SlugLibrary::generate($title);
	}

	public function isLocked()
	{
		return $this->is_locked == 1;
	}
}
