<?php namespace App\Apricot\Repositories;


use App\Customer;

class CustomerRepository
{
	public function all()
	{
		return Customer::all();
	}

	public function rebillAble()
	{
		return Customer::all();
	}
}