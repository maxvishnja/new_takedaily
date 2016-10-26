<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailFlow extends Model
{
	protected $fillable = [
		'name',
		'identifier',
		'is_active'
	];

	public function conditions()
	{
		return $this->belongsToMany(MailFlowCondition::class);
	}

	public function customers()
	{
		return $this->belongsToMany(MailFlowCustomer::class);
	}
}
