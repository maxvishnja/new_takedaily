<?php

namespace App\Http\Controllers\Packer;

use App\Apricot\Repositories\OrderRepository;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

	private $repo;

	function __construct( OrderRepository $repo )
	{
		$this->repo = $repo;
		\App::setLocale( 'en' );
	}

	function index()
	{
		$orders = $this->repo->getPaid()->orderBy( 'created_at', 'DESC' )->with( 'customer.plan' )->get();

		return view( 'packer.orders.home', [
			'orders' => $orders
		] );
	}

	function show( $id )
	{
		$order = Order::find( $id );

		if ( ! $order )
		{
			return \Redirect::back()->withErrors( "The order (#{$id}) could not be found!" );
		}

		$order->load( 'customer.customerAttributes' );

		return view( 'packer.orders.show', [
			'order' => $order
		] );
	}

	function printAll()
	{
		$printableOrders = $this->repo->getPaid()->orderBy( 'created_at', 'DESC' )->shippable()->select('id')->get();

		return $this->downloadMultiple( array_flatten($printableOrders->toArray()) );
	}

	function markSent( $id )
	{
		$order = Order::find( $id );

		if ( ! $order )
		{
			return \Redirect::back()->withErrors( "The order (#{$id}) could not be found!" );
		}

		$order->markSent();

		return \Redirect::action( 'Packer\OrderController@index' )->with( 'success', 'The order was marked as sent!' );
	}

	function handleMultiple( Request $request )
	{
		switch ( $request->get( 'action' ) )
		{
			case 'download':
				$this->downloadMultiple( $request->get( 'ordersForAction' ) );
				break;

			case 'mark-sent':
				$this->markMultipleAsSent( $request->get( 'ordersForAction' ) );
				break;

			case 'combine':
				$this->markMultipleAsSent( $request->get( 'ordersForAction' ) );
				$this->downloadMultiple( $request->get( 'ordersForAction' ) );
				break;
		}

		return \Redirect::action( 'Packer\OrderController@index' )->with( 'success', 'The action was handled!' );
	}

	private function downloadMultiple( $ids )// todo speed this function up
	{
		$printables = [];

		foreach ( Order::whereIn( 'id', $ids )->get() as $order )
		{
			$printables[] = [
				'label'   => $order->loadLabel(),
				'sticker' => $order->loadSticker()
			];
		}

		return view( 'packer.print', [
			'printables' => $printables
		] );
	}

	private function markMultipleAsSent( $ids )
	{
		foreach ( Order::whereIn( 'id', $ids )->get() as $order )
		{
			$order->markSent();
		}
	}
}
