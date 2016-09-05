<?php namespace App; 

use Illuminate\Database\Eloquent\Model;

/**
 * App\CustomerAttribute
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $identifier
 * @property string $value
 * @property boolean $editable
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\CustomerAttribute whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CustomerAttribute whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CustomerAttribute whereIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CustomerAttribute whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CustomerAttribute whereEditable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CustomerAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CustomerAttribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CustomerAttribute editable()
 * @mixin \Eloquent
 */
class CustomerAttribute extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'customer_attributes';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [ 'identifier', 'value', 'editable' ];
	
	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden = [ ];

	public function scopeEditable($query)
	{
		return $query->where('editable', 1);
	}

}