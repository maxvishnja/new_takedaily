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

    public function hasChoice($value)
    {
		return $value == '*' || str_contains($value, [',', '|']);
    }

    public function isDirect()
    {
    	return !$this->hasChoice($this->group_one) && !$this->hasChoice($this->group_two) && !$this->hasChoice($this->group_three);
    }
}
