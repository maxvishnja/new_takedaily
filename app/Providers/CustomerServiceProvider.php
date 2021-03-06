<?php

namespace App\Providers;

use App\Customer;
use App\CustomerAttribute;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Customer::created(function (Customer $customer)
		{
			$customer->customerAttributes()->saveMany([
				new CustomerAttribute([ 'identifier' => 'address_city', 'value' => '', 'editable' => 1 ]),
				new CustomerAttribute([ 'identifier' => 'address_line1', 'value' => '', 'editable' => 1 ]),
				new CustomerAttribute([ 'identifier' => 'address_number', 'value' => '', 'editable' => 1 ]),
				new CustomerAttribute([ 'identifier' => 'address_country', 'value' => '', 'editable' => 1 ]),
				new CustomerAttribute([ 'identifier' => 'address_postal', 'value' => '', 'editable' => 1 ])
			]);
		});

		Customer::deleting(function ($customer)
		{
			$customer->plan->delete();


			foreach ( $customer->orders as $order )
			{
				$order->delete();
			}

			foreach ( $customer->customerAttributes as $attribute )
			{
				$attribute->delete();
			}
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
