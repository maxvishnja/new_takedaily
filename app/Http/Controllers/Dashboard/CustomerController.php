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
		$customer = Customer::find($id);

		if( ! $customer )
		{
			return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
		}

		$customer->load([ 'user', 'customerAttributes', 'plan', 'orders' ]);

		return view('admin.customers.show', [
			'customer' => $customer
		]);
	}

	function newPass($id)
	{
		$customer = Customer::find($id);

		if( ! $customer )
		{
			return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
		}

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
		$customer = Customer::find($id);

		if( ! $customer )
		{
			return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
		}

		if( ! $customer->cancelSubscription(true) )
		{
			return \Redirect::action('Dashboard\CustomerController@show', [ $id ])->withErrors('Kundens abonnent kunne ikke opsiges, fordi det allerede er opsagt.');
		}

		return \Redirect::action('Dashboard\CustomerController@show', [ $id ])->with('success', 'Kundens abonnent er blevet opsagt.');
	}

	function bill($id)
	{
		$customer = Customer::find($id);

		if( ! $customer )
		{
			return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
		}

		if ( $charge = $customer->rebill() )
		{
		// todo this.
		}
	}

	function edit($id)
	{

		// todo
		$customer = Customer::find($id);

		if( ! $customer )
		{
			return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
		}
	}

	function update($id)
	{

		// todo
		$customer = Customer::find($id);

		if( ! $customer )
		{
			return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
		}
	}

	function destroy($id)
	{
		$customer = Customer::find($id);

		if( ! $customer )
		{
			return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
		}

		$customer->delete();

		return \Redirect::action('Dashboard\CustomerController@index')->with('success', 'Kunden blev slettet.');

	}
}
