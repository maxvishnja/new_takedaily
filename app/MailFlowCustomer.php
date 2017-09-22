<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailFlowCustomer extends Model
{
	protected $fillable = [
		'mail_flow_id',
		'customer_id'
	];
}
