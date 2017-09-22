<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TaxZone
 *
 * @property integer $id
 * @property string $name
 * @property integer $rate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\TaxZone whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TaxZone whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TaxZone whereRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TaxZone whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TaxZone whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaxZone extends Model
{
	protected $table = 'tax_zones';

	protected $fillable = [ 'name', 'rate' ];

	protected $hidden = [];
}
