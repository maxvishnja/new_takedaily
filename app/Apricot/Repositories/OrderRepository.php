<?php namespace App\Apricot\Repositories;

use App\Order;

class OrderRepository
{
	public function all()
	{
		return Order::all();
	}

	public function getNew()
	{
		return Order::where('status', 'new');
	}
}