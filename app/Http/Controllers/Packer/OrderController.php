<?php

namespace App\Http\Controllers\Packer;

use App\Apricot\Repositories\OrderRepository;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

	private $repo;

	function __construct(OrderRepository $repo)
	{
		$this->repo = $repo;
		\App::setLocale('en');
	}

	function index()
	{
		$orders = $this->repo->getPaid()->orderBy('created_at', 'DESC')->with('customer.plan')->get();

		return view('packer.orders.home', [
			'orders' => $orders
		]);
	}

	function show($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("The order (#{$id}) could not be found!");
		}

		$order->load('customer.customerAttributes');

		return view('packer.orders.show', [
			'order' => $order
		]);
	}

	function download($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("The order (#{$id}) could not be found!");
		}

		return $order->download();
	}

	function downloadSticker($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("The order (#{$id}) could not be found!");
		}

		return $order->downloadSticker();
	}

	function markSent($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("The order (#{$id}) could not be found!");
		}

		$order->markSent();

		return \Redirect::action('Packer\OrderController@index')->with('success', 'The order was marked as sent!');
	}

	function handleMultiple(Request $request)
	{
		// todo $request->get('action')
		// todo $request->get('ordersForAction')
		dd($request->all());

	}
}
