<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Supplement
 *
 * @property integer $id
 * @property string $name
 * @property string $group_1
 * @property string $group_2
 * @property string $group_3
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Supplement whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Supplement whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Supplement whereGroup1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Supplement whereGroup2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Supplement whereGroup3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Supplement whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Supplement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
