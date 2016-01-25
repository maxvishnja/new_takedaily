<?php namespace App\Apricot\Repositories;

use App\Order;
use Jenssegers\Date\Date;

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

	public function getToday()
	{
		return Order::today();
	}
}