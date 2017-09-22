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
		'should_auto_match',
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

	public function match(Customer $customer)
	{
		$this->customers()->create(['customer_id' => $customer->id]);
	}

	public function sendTo(Customer $customer)
	{
		$this->match($customer);

		$email = $customer->getEmail();
		$name = $customer->getName();
		$identifier = $this->identifier;
		if($customer->getLocale()== 'nl') {
			$fromEmail = 'info@takedaily.nl';
		} else{
			$fromEmail = 'info@takedaily.dk';
		}
		\Mail::queue("emails.mailflow.{$this->identifier}", [ 'customer' => $customer ], function(Message $message) use($email, $name, $identifier, $fromEmail)
		{
			$message->to($fromEmail, 'TakeDaily');
			$message->to($email, $name);
			$message->subject(trans("mails.mailflow.{$identifier}.subject"));
		});
	}
}
