<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{

    protected $table = 'feedback';


    protected $fillable = [
        'title',
        'text',
        'customer_id'
    ];


    public function customer()
    {
        return $this->belongsTo( 'App\Customer', 'id', 'customer_id' );
    }


    public function getCustomer() {

        return $this->customer_id;
    }


}