<?php namespace App; 

use Illuminate\Database\Eloquent\Model;

/**
 * App\Setting
 *
 * @property integer $id
 * @property string $identifier
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'settings';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [ 'identifier', 'value' ];
	
	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden = [ ];

	public static function getWithDefault($identifier = '', $default = null)
	{
		$setting = self::whereIdentifier($identifier)->first();

		if( ! $setting )
		{
			return $default;
		}

		return $setting->value;
	}

}