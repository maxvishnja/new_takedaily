<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actions extends Model
{
    protected $table = 'actions';


    protected $fillable = [
        'title',
        'price_da',
        'price_nl',
        'active'
    ];


}