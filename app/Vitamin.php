<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vitamin extends Model
{
    protected $fillable = [
	    'name',
        'code',
        'description'
    ];
}
