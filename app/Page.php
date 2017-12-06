<?php

namespace App;

use App\Apricot\Libraries\SlugLibrary;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Page
 *
 * @property integer $id
 * @property string $url_identifier
 * @property string $title
 * @property string $sub_title
 * @property string $body
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_image
 * @property boolean $is_locked
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $layout
 * @property string $top_image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PageTranslation[] $translations
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereUrlIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereSubTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereMetaTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereMetaDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereMetaImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereIsLocked($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereLayout($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereTopImage($value)
 * @mixin \Eloquent
 */
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
