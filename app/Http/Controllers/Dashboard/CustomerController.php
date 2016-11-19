<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\CustomerRepository;
use App\Customer;
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

		\Mail::queue('emails.new-password', [ 'locale' => \App::getLocale(), 'password' => $password ], function (Message $message) use ($customer)
		{
			$message->to($customer->user->getEmailForPasswordReset(), $customer->getName());
			$message->subject(trans('mails.new-password.subject'));
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

		if ( ! $charge = $customer->rebill() )
		{
			return \Redirect::back()->withErrors("Der kunne ikke trækkes penge fra kunden!");
		}

		$lastOrder = $customer->orders()->latest()->first();

		return \Redirect::action('Dashboard\CustomerController@show', [ $id ])->with('success', "Der blev trukket penge fra kundens konto, og en ny ordre (#{$lastOrder->id}) blev oprettet. <a href=\"" . \URL::action('Dashboard\OrderController@show', [ $lastOrder->id ]) . "\">Vis ordre</a>");
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
