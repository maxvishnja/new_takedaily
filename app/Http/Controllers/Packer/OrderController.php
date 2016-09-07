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
		switch ( $request->get('action') )
		{
			case 'download':
				$this->downloadMultiple($request->get('ordersForAction'));
				break;

			case 'mark-sent':
				$this->markMultipleAsSent($request->get('ordersForAction'));
				break;

			case 'combine':
				$this->markMultipleAsSent($request->get('ordersForAction'));
				$this->downloadMultiple($request->get('ordersForAction'));
				break;
		}

		return \Redirect::action('Packer\OrderController@index')->with('success', 'The action was handled!');
	}

	private function downloadMultiple($ids)
	{
		$stickers = [];
		$labels   = [];

		foreach ( Order::whereIn('id', $ids)->get() as $order )
		{
			$labels[]   = $order->loadLabel();
			$stickers[] = $order->loadSticker();
		}

		$newFolder    = date('Ymd_') . str_random(10);
		\File::makeDirectory(public_path('packer/downloads/' . $newFolder));

		$labelsName   = 'labels_' . date('Ymd_Hi') . '.pdf';
		$labelPath    = 'packer/downloads/' . $newFolder . '/' . $labelsName;
		$stickersName = 'stickers_' . date('Ymd_Hi') . '.pdf';
		$stickerPath  = 'packer/downloads/' . $newFolder . '/' . $stickersName;

		\PDF::loadView('pdf.multiple-labels', [ 'labels' => $labels ])
		    ->setPaper([ 0, 0, 570, 262 ])
		    ->setOrientation('landscape')
		    ->save(public_path($labelPath));

		\PDF::loadView('pdf.multiple-stickers', [ 'stickers' => $stickers ])
		    ->setPaper([ 0, 0, 531, 723 ])
		    ->setOrientation('portrait')
		    ->save(public_path($stickerPath));

		\Session::flash('links', [
			[
				'label' => $labelsName,
				'url'   => url($labelPath)
			],
			[
				'label' => $stickersName,
				'url'   => url($stickerPath)
			]
		]);
	}

	private function markMultipleAsSent($ids)
	{
		foreach ( Order::whereIn('id', $ids)->get() as $order )
		{
			$order->markSent();
		}
	}
}
