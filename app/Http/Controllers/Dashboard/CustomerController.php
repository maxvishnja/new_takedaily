<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\CustomerRepository;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Order;
use App\Vitamin;
use Illuminate\Mail\Message;
use Illuminate\Http\Request;
use App\Http\Requests;

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

	function edit($id)
	{
		$customer = Customer::find($id);

		if( ! $customer )
		{
			return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
		}

		$allvitamins = \DB::table('ltm_translations')->where([['group', '=', 'pill-names'], ['locale', '=', 'nl']])->get();
		$customer->load([ 'user', 'customerAttributes', 'plan', 'orders' ]);

		return view('admin.customers.edit', [
			'customer' => $customer,
			'allvit' => $allvitamins
		]);
	}



	function update(Request $request, $id)
	{
		$customer = Customer::find($id);
		$order = Order::where([['state', '=', 'paid'],['customer_id', '=', $id]])->first();

		if( ! $customer )
		{
			return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
		}

		foreach($customer->customerAttributes as $ident){
			if($ident->identifier == 'user_data.birthdate'){
				$ident->value = $request->get('user_data_birthdate');
				$ident->update();
			}
			if($ident->identifier == 'phone'){
				$ident->value = $request->get('phone');
				$ident->update();
			}
			if($ident->identifier == 'address_line1'){
				$ident->value = $request->get('address_line1');
				$order->shipping_street = $request->get('address_line1');
				$order->update();
				$ident->update();
			}
			if($ident->identifier == 'address_city'){
				$ident->value = $request->get('address_city');
				$order->shipping_city = $request->get('address_city');
				$order->update();
				$ident->update();
			}
			if($ident->identifier == 'address_country'){
				$ident->value = $request->get('address_country');
				$order->shipping_country = $request->get('address_country');
				$order->update();
				$ident->update();

			}
			if($ident->identifier == 'address_postal'){
				$ident->value = $request->get('address_postal');
				$order->shipping_zipcode = $request->get('address_postal');
				$order->update();
				$ident->update();
			}
			if($ident->identifier == 'user_data.age'){
				$ident->value = $customer->getAge();
				$ident->update();
			}
		}

		$usernew['name'] = $request->get('cust_name');
		$order->shipping_name = $request->get('cust_name');
		$usernew['email'] = $request->get('cust_email');
		$customer->user->update($usernew);
		$order->update();


		if($request->get('vitamin-1')){
			foreach($request->get('vitamin-1') as $vit1){
				$vitamins_one = Vitamin::where('code', '=', $vit1)->value('id');
			}
		}
		if($request->get('vitamin-2')){
			foreach($request->get('vitamin-2') as $vit2) {
				$vitamins_two = Vitamin::where('code', '=', strtoupper($vit2))->value('id');
			}
		}
		if($request->get('vitamin-3')){
			foreach($request->get('vitamin-3') as $vit3) {
				$vitamins_three[] = Vitamin::where('code', '=', $vit3)->value('id');
			}
		}

		$vitamins = '[';

		if(isset($vitamins_one)) {
			$vitamins .=  $vitamins_one . ',';
		}

		if(isset($vitamins_two)) {
			$vitamins .= $vitamins_two . ',';
		}

		if(isset($vitamins_three[0])) {
			$vitamins .= $vitamins_three[0];
		}

		if(isset($vitamins_three[1])) {
			$vitamins .= ','.$vitamins_three[1];
		}
		$vitamins .= ']';

		if($vitamins!='[]'){
			$customer->plan->vitamins = $vitamins;
			$customer->plan->update();
		}


		return \Redirect::action('Dashboard\CustomerController@index')->with('success', 'Kunden er blevet ændret.');
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
