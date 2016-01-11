<?php namespace App; 

use Illuminate\Database\Eloquent\Model;

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