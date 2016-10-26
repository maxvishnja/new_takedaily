<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailFlow extends Model
{
	protected $fillable = [
		'name',
		'identifier',
		'is_active',
		'only_once'
	];

	public function conditions()
	{
		return $this->hasMany(MailFlowCondition::class);
	}

	public function customers()
	{
		return $this->hasMany(MailFlowCustomer::class);
	}
}
