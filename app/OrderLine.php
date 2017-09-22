<?php namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\OrderLine
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $description
 * @property integer $amount
 * @property integer $tax_amount
 * @property integer $total_amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\OrderLine whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderLine whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderLine whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderLine whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderLine whereTaxAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderLine whereTotalAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderLine whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderLine whereDeletedAt($value)
 * @mixin \Eloquent
 */
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
	protected $fillable = [ 'description', 'order_id', 'amount', 'tax_amount', 'total_amount' ];
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];


}