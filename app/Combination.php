<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Combination
 *
 * @property integer $id
 * @property string $group_1
 * @property string $group_2
 * @property string $group_3
 * @property boolean $combination_possible
 * @property string $combination_result
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Combination whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Combination whereGroup1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Combination whereGroup2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Combination whereGroup3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Combination whereCombinationPossible($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Combination whereCombinationResult($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Combination whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Combination whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Combination extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'combinations';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'combination_possible',
		'combination_result',
		'group_1',
		'group_2',
		'group_3'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];

	public function isPossible()
	{
		return $this->combination_possible == 1;
	}
}
