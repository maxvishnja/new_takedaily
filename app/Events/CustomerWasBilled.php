<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class CustomerWasBilled
 * @package App\Events
 */
class CustomerWasBilled extends Event
{
	use SerializesModels;

	public $customerId;
	public $orderAmount;
	public $chargeToken;
	public $product;
	public $balance;
	public $balanceAmount;
	public $coupon;

	/**
	 * CustomerWasBilled constructor.
	 *
	 * @param int    $customerId
	 * @param int    $amount
	 * @param string $chargeToken
	 * @param string $product
	 * @param bool   $balance
	 * @param int    $balanceAmount
	 * @param mixed  $coupon
	 */
	public function __construct( $customerId, $amount = 100, $chargeToken = '', $product = 'subscription', $balance = false, $balanceAmount = 0, $coupon )
	{
		$this->customerId    = $customerId;
		$this->orderAmount   = $amount;
		$this->chargeToken   = $chargeToken;
		$this->product       = $product;
		$this->balance       = $balance;
		$this->balanceAmount = $balanceAmount;
		$this->coupon        = $coupon;
	}

	/**
	 * Get the channels the event should be broadcast on.
	 *
	 * @return array
	 */
	public function broadcastOn()
	{
		return [];
	}
}
