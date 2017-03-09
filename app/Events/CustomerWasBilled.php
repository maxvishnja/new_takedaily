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
	public $gift;
	public $order_plan;

	/**
	 * CustomerWasBilled constructor.
	 *
	 * @param int $customerId
	 * @param int $amount
	 * @param string $chargeToken
	 * @param string $product
	 * @param bool $balance
	 * @param int $balanceAmount
	 * @param mixed $coupon
	 * @param $gift
	 * @param $order_plan
	 */
	public function __construct( $customerId, $amount = 100, $chargeToken = '', $product = 'subscription', $balance = false, $balanceAmount = 0, $coupon, $gift, $order_plan )
	{
		$this->customerId    = $customerId;
		$this->orderAmount   = $amount;
		$this->chargeToken   = $chargeToken;
		$this->product       = $product;
		$this->balance       = $balance;
		$this->balanceAmount = $balanceAmount;
		$this->coupon        = $coupon;
		$this->gift        	 = $gift;
		$this->order_plan    = $order_plan;
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
