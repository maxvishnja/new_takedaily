<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\OrderRepository;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;

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

		return view('admin.orders.show', [
			'order' => Order::find($id)
		]);
	}
}
