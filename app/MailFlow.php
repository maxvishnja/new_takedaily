<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Message;

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

	public function sendTo(Customer $customer)
	{
		$this->customers()->create(['customer_id' => $customer->id]);

		$email = $customer->getEmail();
		$name = $customer->getName();
		$identifier = $this->identifier;

		\Mail::queue("emails.mailflow.{$this->identifier}", [ 'customer' => $customer ], function(Message $message) use($email, $name, $identifier)
		{
			$message->to($email, $name);
			$message->subject(trans("mails.mailflow.{$identifier}.subject"));
		});
	}
}
