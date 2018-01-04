<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Date\Date;

class Nutritionist extends Model
{

    use SoftDeletes;

    /**
     * The database table for the model
     *
     * @var string
     */
    protected $table = 'nutritionists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['id', 'first_name', 'last_name', 'title', 'image', 'email', 'locale', 'active', 'order'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}