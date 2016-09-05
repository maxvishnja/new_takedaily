<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

/**
 * App\Currency
 *
 * @property integer $id
 * @property string $name
 * @property integer $rate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Currency whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Currency whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Currency whereRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Currency extends Model
{
	use Rememberable;

	protected $fillable = [
		'name',
		'rate'
	];
}
