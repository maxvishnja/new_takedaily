<?php

namespace App\Events;

use App\Customer;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class CustomerWasBilled
 * @package App\Events
 */
class CustomerWasBilled extends Event
{
	use SerializesModels;

	public $customer;
	public $orderAmount;
	public $stripeToken;

	/**
	 * Create a new event instance.
	 *
	 * @param Customer $customer
	 * @param integer $amount
	 * @param string $stripeToken
	 */
	public function __construct(Customer $customer, $amount = 100, $stripeToken = '')
	{
		$this->customer       = $customer;
		$this->orderAmount    = $amount;
		$this->stripeToken   = $stripeToken;
	}

	/**
	 * Get the channels the event should be broadcast on.
	 *
	 * @return array
	 */
	public function broadcastOn()
	{
		return [ ];
	}
}
