<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Call
 *
 * @property integer $id
 * @property string $phone
 * @property string $period
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Call whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Call wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Call wherePeriod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Call whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Call whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Call whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Call extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'calls';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'phone',
		'period',
		'status'
	];
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];


}