<?php namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

	use SoftDeletes;

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'products';
	
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