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

    public function getOpenOrder()
    {
        return Order::where('state', '=', 'paid')->orWhere('state', '=', 'printed');
    }

	public function getShipped()
	{
		return Order::where('state', 'sent');
	}

	public function getPrinted()
	{
		return Order::where('state', 'printed');
	}


	public function getToday()
	{
		return Order::today();
	}

    public function getPickToday()
    {
        $orders = Order::today()->get();

        $count = 0;

        if(count($orders) > 0){
           foreach ($orders as $order) {
              if($order->getCustomer()->getPlan()->is_custom == 1){
                  $count++;
              }
           }
        }

        return $count;


    }

	public function getMonthlySales()
	{
		return Order::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month, sum(total) as total")
					->groupBy(\DB::raw("YEAR(created_at), MONTH(created_at)"))
					->get();
	}

    public function getMonthlyOrder()
    {
        return Order::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month, COUNT(DISTINCT id) as total")
            ->groupBy(\DB::raw("YEAR(created_at), MONTH(created_at)"))
            ->get();
    }
}