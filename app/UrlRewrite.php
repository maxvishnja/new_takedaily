<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UrlRewrite
 *
 * @property integer $id
 * @property string $requested_path
 * @property string $actual_path
 * @property integer $redirect_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\UrlRewrite whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UrlRewrite whereRequestedPath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UrlRewrite whereActualPath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UrlRewrite whereRedirectType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UrlRewrite whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UrlRewrite whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
