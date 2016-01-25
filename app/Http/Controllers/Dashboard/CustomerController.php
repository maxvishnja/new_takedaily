<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\CustomerRepository;
use App\Customer;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Message;

class CustomerController extends Controller
{

	private $repo;

	function __construct(CustomerRepository $repository)
	{
		$this->repo = $repository;
	}

	function index()
	{
		$customers = $this->repo->all();
		$customers->load('user');

		return view('admin.customers.home', [
			'customers' => $customers
		]);
	}

	function show($id)
	{
		// todo verify exists

		$customer = Customer::find($id);
		$customer->load([ 'user', 'customerAttributes', 'plan', 'orders' ]);

		return view('admin.customers.show', [
			'customer' => $customer
		]);
	}

	function newPass($id)
	{
		// todo verify exists
		$customer = Customer::find($id);
		$customer->load('user');
		$password = str_random(8);

		$customer->user->password = \Hash::make($password);
		$customer->user->save();

		\Mail::queue('emails.new-password', [ 'password' => $password ], function (Message $message) use ($customer)
		{
			$message->to($customer->user->getEmailForPasswordReset(), $customer->getName());
			$message->subject('Din nye adgangskode til TakeDaily'); // todo translate
			$message->from('noreply@takedaily.com', 'TakeDaily');
		});

		return \Redirect::action('Dashboard\CustomerController@show', [ $id ])->with('success', 'Kunden har fået tilsendt en ny adgangskode!');
	}

	function cancel($id)
	{
		// todo verify exists

		if( ! Customer::find($id)->cancelSubscription(true) )
		{
			return \Redirect::action('Dashboard\CustomerController@show', [ $id ])->withErrors('Kundens abonnent kunne ikke opsiges, fordi det allerede er opsagt.');
		}

		return \Redirect::action('Dashboard\CustomerController@show', [ $id ])->with('success', 'Kundens abonnent er blevet opsagt.');
	}

	function bill($id)
	{
		// todo verify exists
		if ( $charge = Customer::find($id)->rebill() )
		{
		// todo this.
		}
	}

	function edit($id)
	{

		// todo verify exists
	}

	function update($id)
	{

		// todo verify exists
	}

	function destroy($id)
	{

		// todo verify exists
	}
}
