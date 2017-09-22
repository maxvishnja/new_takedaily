<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snoozing extends Model
{
    protected $table = 'snoozing';

    protected $fillable = [
        'customer_id',
        'email',
        'open'
    ];


    public function customer()
    {
        return $this->belongsTo( 'App\Customer', 'id', 'customer_id' );
    }

}
