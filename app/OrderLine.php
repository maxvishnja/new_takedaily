<?php namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLine extends Model
{

	use SoftDeletes;

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'order_lines';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [ ];
	
	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden = [ ];

}