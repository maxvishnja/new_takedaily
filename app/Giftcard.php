<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Giftcard
 *
 * @property integer $id
 * @property string $token
 * @property integer $worth
 * @property boolean $is_used
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Giftcard whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Giftcard whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Giftcard whereWorth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Giftcard whereIsUsed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Giftcard whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Giftcard whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Giftcard extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'giftcards';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'token',
		'worth',
		'is_used'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];

	public function markUsed()
	{
		$this->is_used = 1;
		$this->save();
	}
}
