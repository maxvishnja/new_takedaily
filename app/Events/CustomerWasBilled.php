<?php

namespace App\Events;

use App\Customer;
use Illuminate\Queue\SerializesModels;

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
	public $product;

	/**
	 * Create a new event instance.
	 *
	 * @param Customer $customer
	 * @param integer  $amount
	 * @param string   $stripeToken
	 * @param string   $product
	 */
	public function __construct(Customer $customer, $amount = 100, $stripeToken = '', $product = 'subscription')
	{
		$this->customer    = $customer;
		$this->orderAmount = $amount;
		$this->stripeToken = $stripeToken;
		$this->product     = $product;
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
