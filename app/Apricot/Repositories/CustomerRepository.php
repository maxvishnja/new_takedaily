<?php namespace App\Apricot\Repositories;


use App\Customer;

class CustomerRepository
{
	public function all()
	{
		return Customer::orderBy('created_at', 'DESC')->get();
	}

	public function rebillAble()
	{
		return Customer::rebillable();
	}

	public function getToday()
	{
		return Customer::today();
	}

	public function getMonthlyNew()
	{
		return Customer::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month, COUNT(DISTINCT id) as total")
					->groupBy(\DB::raw("YEAR(created_at), MONTH(created_at)"))
					->get();
	}
}