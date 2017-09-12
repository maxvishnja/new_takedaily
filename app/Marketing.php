<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    protected $table = 'marketing';


    protected $fillable = [
        'source',
        'medium',
        'campaign',
        'clientId',
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
