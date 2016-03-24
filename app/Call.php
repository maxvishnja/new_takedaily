<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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