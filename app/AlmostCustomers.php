<?php namespace App;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Notes
 * @mixin \Eloquent
 */
class AlmostCustomers extends Model
{


    /**
     * The database table for the model
     *
     * @var string
     */
    protected $table = 'almost_customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'location',
        'token',
        'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */


}