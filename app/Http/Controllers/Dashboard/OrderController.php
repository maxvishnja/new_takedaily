<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\OrderRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests;
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
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("Ordren (#{$id}) kunne ikke findes!");
		}

		$coupon = $order->getCoupon();

		$order->load('customer.customerAttributes');

		return view('admin.orders.show', [
			'order' => $order,
			'coupon' => $coupon,
		]);
	}

	function edit($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("Ordren (#{$id}) kunne ikke findes!");
		}

		return view('admin.orders.manage', [
			'order' => $order
		]);
	}

	function refund($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("Ordren (#{$id}) kunne ikke findes!");
		}

		$order->refund();

		return \Redirect::action('Dashboard\OrderController@index')->with('success', 'Ordren blev refunderet.');
	}

	function download($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("Ordren (#{$id}) kunne ikke findes!");
		}

		return $order->download();
	}

	function downloadSticker($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("Ordren (#{$id}) kunne ikke findes!");
		}

		return $order->downloadSticker();
	}

	function markSent($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("Ordren (#{$id}) kunne ikke findes!");
		}

		$order->markSent();

		return \Redirect::action('Dashboard\OrderController@index')->with('success', 'Ordren blev markeret som afsendt, og kunden har fået besked!');
	}

	function update($id, Request $request)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("Ordren (#{$id}) kunne ikke findes!");
		}

		$order->state = $request->get('state');
		$order->save();

		return \Redirect::action('Dashboard\OrderController@index')->with('success', 'Ordren blev opdateret!');
	}

	function destroy($id)
	{
		$order = Order::find($id);

		if ( !$order )
		{
			return \Redirect::back()->withErrors("Ordren (#{$id}) kunne ikke findes!");
		}

		$order->delete();

		return \Redirect::action('Dashboard\OrderController@index')->with('success', 'Ordren blev slettet!');
	}
}
