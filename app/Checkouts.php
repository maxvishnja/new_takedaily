<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Currency
 *
 * @property integer $id
 * @property string $name
 * @property integer $rate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class Checkouts extends Model
{

    protected $table = 'checkout';

    protected $fillable = [
        'data',
        'charge_id'
    ];
}
