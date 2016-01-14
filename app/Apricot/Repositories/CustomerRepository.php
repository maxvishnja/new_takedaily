<?php namespace App\Apricot\Repositories;


use App\Customer;
use Jenssegers\Date\Date;

class CustomerRepository
{
	public function all()
	{
		return Customer::all();
	}

	public function rebillAble()
	{
		return Customer::all(); // todo
	}

	public function getToday()
	{
		return Customer::today();
	}
}