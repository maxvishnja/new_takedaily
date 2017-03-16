<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snoozing extends Model
{
    protected $table = 'snoozing';

    protected $fillable = [
        'customer_id',
        'email',
        'send',
        'open'
    ];

}
