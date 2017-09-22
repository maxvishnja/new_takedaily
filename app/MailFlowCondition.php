<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailFlowCondition extends Model
{
    protected $fillable = [
	    'mail_flow_id',
		'key',
		'type',
		'value'
    ];
}
