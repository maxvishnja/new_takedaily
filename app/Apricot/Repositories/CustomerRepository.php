<?php namespace App\Apricot\Repositories;


use App\Customer;
use App\Plan;

class CustomerRepository
{
	public function all()
	{
		return Customer::orderBy('created_at', 'DESC')->get();
	}

	public function allActive()
	{
		return Plan::whereNull('subscription_cancelled_at')->count();
	}

	public function rebillAble()
	{
		return Customer::rebillable();
	}

	public function getToday()
	{
		return Customer::today();
	}

	public function getNewCustomer(){
		$date = new \DateTime();
		$date->modify('-14 days');
		return Customer::where('order_count','=',1)
			->where('created_at','like','%'.$date->format('Y-m-d').'%')
			->get();
	}

	public function getMonthlyNew()
	{
		return Customer::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month, COUNT(DISTINCT id) as total")
					->groupBy(\DB::raw("YEAR(created_at), MONTH(created_at)"))
					->get();
	}
}