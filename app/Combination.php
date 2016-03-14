<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
