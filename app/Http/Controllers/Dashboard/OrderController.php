<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\OrderRepository;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

	private $repo;

	function __construct(OrderRepository $repo)
	{
		$this->repo = $repo;
	}

	function index()
	{
		$orders = $this->repo->all();

		return view('admin.orders.home', [
			'orders' => $orders
		]);
	}

	function show($id)
	{
		// todo check if exists

		$order = Order::find($id);
		$order->load('lines.products.product');
		$order->load('customer.customerAttributes');

		return view('admin.orders.show', [
			'order' => $order
		]);
	}

	function edit($id)
	{
		// todo check if exists

		$order = Order::find($id);

		return view('admin.orders.manage', [
			'order' => $order
		]);
	}

	function update($id, Request $request)
	{
		// todo check if exists

		$order        = Order::find($id);
		$order->state = $request->get('state');
		$order->save();

		return \Redirect::action('Dashboard\OrderController@index')->with('success', 'Ordren blev opdateret!');
	}

	function destroy($id)
	{
		// todo check if exists

		Order::find($id)->delete();

		return \Redirect::action('Dashboard\OrderController@index')->with('success', 'Ordren blev slettet!');
	}
}
