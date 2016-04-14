<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxZone extends Model
{
	protected $table = 'tax_zones';

	protected $fillable = [ 'name', 'rate' ];

	protected $hidden = [];
}
