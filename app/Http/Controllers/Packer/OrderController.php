<?php

namespace App\Http\Controllers\Packer;

use App\Apricot\Repositories\OrderRepository;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Jenssegers\Date\Date;
use App\Jobs\SentNewMail;

class OrderController extends Controller
{

	private $repo;

	function __construct( OrderRepository $repo )
	{
		$this->repo = $repo;
		//\App::setLocale( 'en' );
	}

	function index()
	{
		$orders = $this->repo->getPaid()->shippable()->orderBy( 'created_at', 'DESC' )->with( 'customer.plan' )->get();

		return view( 'packer.orders.home', [
			'orders' => $orders
		] );
	}

	function sent()
	{
		$orders = $this->repo->getShipped()->orderBy( 'created_at', 'DESC' )->with( 'customer.plan' )->get();

		return view( 'packer.orders.sent', [
			'orders' => $orders
		] );
	}



	function printed()
	{
		$orders = $this->repo->getPrinted()->orderBy( 'created_at', 'DESC' )->with( 'customer.plan' )->get();

		return view( 'packer.orders.printed', [
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
        /** @var Collection $orders_dk */
        $orders_dk = $this->repo->getBarcode()
            ->shippable()
            ->select('orders.*')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->where('customers.locale', 'da')
            ->get();

        $orders_nl = $this->repo->getPaid()
            ->shippable()
            ->select('orders.*')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->where('customers.locale', 'nl')
            ->get();

        $orders = $orders_dk->merge($orders_nl);


//		$printableOrders = $this->repo->getPaid()->orderBy( 'created_at', 'DESC' )->shippable()->select('id')->get();

//		return $this->downloadMultiple( array_flatten($printableOrders->toArray()) );

		return $this->downloadMultiple( $orders );
	}

	function shipAll()
	{
		$printableOrders = $this->repo->getPrinted()->orderBy( 'created_at', 'DESC' )->shippable()->get();

		/** @var Order $order */
		foreach($printableOrders as $order)
		{

			$order->markSent();
           // $this->dispatch(new SentNewMail($order, 'sent'));
		}

		return \Redirect::back()->with('success', 'Done!');
	}

	function markSent( $id )
	{
		$order = Order::find( $id );

		if ( ! $order )
		{
			return \Redirect::back()->withErrors( "The order (#{$id}) could not be found!" );
		}


		$order->markSent();


       // $this->dispatch(new SentNewMail($order, 'sent'));

		return \Redirect::action( 'Packer\OrderController@index' )->with( 'success', 'The order was marked as sent!' );
	}

	function print( $id )
	{
		return $this->downloadMultiple( [$id] );
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

	private function downloadMultiple( $ids_or_orders )
	{
		$printables = [];

		$orders = $ids_or_orders instanceof Collection
            ? $ids_or_orders
            : Order::whereIn( 'id', $ids_or_orders )->get();

		foreach ( $orders as $order )
		{
			$order->markPrint();
            //$this->dispatch(new SentNewMail($order, 'print'));

			$printables[] = [
				'label'   => $order->loadLabel(),
				'sticker' => $order->loadSticker(),
			    'locale' => $order->getCustomer()->getLocale()
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
            //$this->dispatch(new SentNewMail($order, 'sent'));
		}
	}

    public function getAllBarcodeDK()
    {

        $orders = $this->repo->getEmptyBarcode()
            ->shippable()
            ->select('orders.*')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->where('customers.locale', 'da')
            ->orderBy('created_at', 'DESC')
            ->with('customer.plan')
            ->get();

        $barcodes = [];

        foreach ($orders as $order) {

            $order_id = $order->id;
            $customer_name = $order->getCustomer()->getUser()->name;
            $customer_email = $order->getCustomer()->getUser()->email;
            $customer_phone = $order->getCustomer()->getCustomerAttribute('phone');

            $shipping_zipcode  = $order->shipping_zipcode;
            $shipping_street = $order->shipping_street;
            $shipping_number =  $order->getCustomer()->getCustomerAttribute('address_number');
            if($shipping_number != ''){
                $street = $shipping_street." ".$shipping_number;
            } else{
                $temp_street = explode(", ", $shipping_street);
                $street = $temp_street['0'];
            }
            $date = Date::now()->addDay()->format('Y-m-d');

            $client = new Client();
            $res = $client->request('GET', 'https://api.dao.as/DAODirekte/leveringsordre.php?kundeid=1332&kode=eb7kr6b7dsr5&postnr='.$shipping_zipcode.'&adresse='.$street.'&navn='.$customer_name.'&mobil='.$customer_phone.'&email='.$customer_email.'&vaegt=200&l=27&h=20&b=2&faktura='.$order_id.'&dato='.$date.'&format=json');

            $response = json_decode($res->getBody());
            $status = $response->status;

            if (strtolower($status) == 'ok') {
                $order->barcode = json_decode($res->getBody())->resultat->stregkode;
                $order->labelTekst1 = json_decode($res->getBody())->resultat->labelTekst1;
                $order->labelTekst2 = json_decode($res->getBody())->resultat->labelTekst2;
                $order->labelTekst3 = json_decode($res->getBody())->resultat->labelTekst3;
                $order->udsortering = json_decode($res->getBody())->resultat->udsortering;
                $order->eta = json_decode($res->getBody())->resultat->ETA;
                $order->save();
                $barcodes[$order_id] = $response->resultat->stregkode;
            }

        }
        return \Response::json([
            'message' => 'OK'
        ]);
    }

	public function getBarcodeDK(Request $request)
    {
        $data = $request->all();

        $order =  Order::where( 'id', $data )->first();




            $order_id = $order->id;
            $customer_name = $order->getCustomer()->getUser()->name;
            $customer_email = $order->getCustomer()->getUser()->email;
            $customer_phone =$order->getCustomer()->getCustomerAttribute('phone');
            $shipping_zipcode  = $order->getCustomer()->getCustomerAttribute('address_postal');
            $shipping_street =  $order->getCustomer()->getCustomerAttribute('address_line1');
            $shipping_number =  $order->getCustomer()->getCustomerAttribute('address_number');
            if($shipping_number != ''){
                $street = $shipping_street." ".$shipping_number;
            } else{
                $temp_street = explode(", ", $shipping_street);
                $street = $temp_street['0'];
            }
            $date = Date::now()->addDay()->format('Y-m-d');



                $client = new Client();
                $res = $client->request('GET', 'https://api.dao.as/DAODirekte/leveringsordre.php?kundeid=1332&kode=eb7kr6b7dsr5&postnr='.$shipping_zipcode.'&adresse='.$street.'&navn='.$customer_name.'&mobil='.$customer_phone.'&email='.$customer_email.'&vaegt=200&l=27&h=20&b=2&faktura='.$order_id.'&dato='.$date.'&format=json');

                $status = json_decode($res->getBody())->status;

                if (strtolower($status) == 'ok') {
                    $order->barcode = json_decode($res->getBody())->resultat->stregkode;
                    $order->labelTekst1 = json_decode($res->getBody())->resultat->labelTekst1;
                    $order->labelTekst2 = json_decode($res->getBody())->resultat->labelTekst2;
                    $order->labelTekst3 = json_decode($res->getBody())->resultat->labelTekst3;
                    $order->udsortering = json_decode($res->getBody())->resultat->udsortering;
                    $order->eta = json_decode($res->getBody())->resultat->ETA;
                    $order->save();
                    return \Response::json([
                        'message' => json_decode($res->getBody())->resultat->stregkode
                    ]);
                }else{
                    return \Response::json([
                        'message' => 'Error',
                        'result' => json_decode($res->getBody())->fejltekst
                    ]);
                }



//        }

    }

    public function cancelDeliveryDK(Request $request)
    {
        $data = $request->all();

        $order = Order::where( 'id', $data['id'] )->first();

        $client = new Client();
        $res = $client->request('GET', 'https://api.dao.as/AnnullerePakke.php?kundeid=1332&kode=eb7kr6b7dsr5&stregkode='.$data['barcode'].'&format=json');

        $status = json_decode($res->getBody())->status;

//        echo "<pre>";
//        var_dump(json_decode($res->getBody())->status);
//        echo "</pre>";

        if($status == 'OK'){
            $order->barcode = '';
            $order->labelTekst1 = '';
            $order->labelTekst2 = '';
            $order->labelTekst3 = '';
            $order->udsortering = '';
            $order->eta = '';
            $order->save();
            return \Response::json([
                'message' => $data['id']
            ]);
        }else{
            return \Response::json([
                'message' => 'Error'
            ]);
        }




    }

}
