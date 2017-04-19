<?php namespace App;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Notes
 * @mixin \Eloquent
 */
class Notes extends Model
{


    /**
     * The database table for the model
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'author',
        'date',
        'note'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */


    public function customer()
    {
        return $this->hasOne( 'App\Customer', 'id', 'customer_id' );
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }


    public function getNote()
    {
        return $this->note;
    }


    public function getAuthor()
    {
        return $this->author;
    }


}