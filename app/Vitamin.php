<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

/**
 * App\Vitamin
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Vitamin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vitamin whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vitamin whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vitamin whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vitamin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vitamin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vitamin extends Model
{
	use Rememberable;

    protected $fillable = [
	    'name',
        'code',
        'description'
    ];
}
