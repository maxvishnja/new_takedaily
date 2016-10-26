<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
    	'identifier',
        'group_one',
        'group_two',
        'group_three',
    ];
}
