<?php namespace App\Apricot\Repositories;


use App\Customer;
use Jenssegers\Date\Date;

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
}