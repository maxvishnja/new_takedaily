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
		return Order::where('state', '!=', 'sent');
	}

	public function getShipped()
	{
		return Order::where('state', 'sent');
	}

	public function getToday()
	{
		return Order::today();
	}

	public function getMonthlySales()
	{
		return Order::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month, sum(total) as total")
					->groupBy(\DB::raw("YEAR(created_at), MONTH(created_at)"))
					->get();
	}
}