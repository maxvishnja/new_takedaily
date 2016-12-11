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
        'description',
        'type'
    ];

    public function getInfo()
    {
    	$group = $this->code[0];
    	$item = $this->code[1];

    	if( (int) $group === 1)
	    {
	    	switch($item)
		    {
			    case (int) 1:
			    case 'a':
			    	$item = 'basic';
			    	break;
			    case (int) 2:
			    case 'b':
			    	$item = 'basic-10-d';
			    	break;
			    case (int) 3:
			    case 'c':
			    	$item = 'basic-20-d';
			    	break;
		    }
	    }

    	if( (int) $group === 2)
	    {
	    	$item = strtoupper($item);
	    }

    	return trans("flow.combination_info.{$group}.{$item}");
    }
}
