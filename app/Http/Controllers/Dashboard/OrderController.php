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

    function createCsv(){

        $opens = $this->repo->getOpenOrder()->get();

            if(count($opens) > 0){
                $email_array = [];
                $i = 0;
                foreach ($opens as $order) {

                    $email_array[$i]['Email Address'] = $order->customer->getEmail();
                    $email_array[$i]['First Name'] = $order->customer->getFirstName();

                    if($order->customer->getLocale() == 'da'){
                        $country = 'Denmark';
                    } else{
                        $country = 'Netherlands';
                    }

                    $email_array[$i]['Country'] = $country;
                    $i++;


                }


                \Excel::create('open_orders', function ($excel) use ($email_array) {

                    $excel->sheet('All open orders', function ($sheet) use ($email_array) {

                        $sheet->fromArray($email_array, null, 'A1', true);

                    });

                })->download('xls');
                return \Redirect::back();
        }

    }











}
