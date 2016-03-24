<?php namespace App\Apricot\Repositories;

use App\Order;

class OrderRepository
{
	public function all()
	{
		return Order::orderBy('created_at', 'DESC')->get();
	}

	public function getNew()
	{
		return Order::where('state', 'new');
	}

	public function getPaid()
	{
		return Order::where('state', 'paid');
	}

	public function getNotShipped()
	{
		return Order::where('state', '!=', 'shipped');
	}

	public function getToday()
	{
		return Order::today();
	}
}