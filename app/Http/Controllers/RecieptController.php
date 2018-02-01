<?php


namespace App\Http\Controllers;


use App\Order;
use Illuminate\Http\Request;

class RecieptController extends Controller
{

    public function sendReciept(Request $request){

        $order = Order::find($request->get('id'));

        $mailName = $order->customer->getName();
        $locale = $order->customer->getLocale();
        $mailEmail =  $request->get('email');


        if($locale == 'nl') {
            $fromEmail = 'info@takedaily.nl';
        } else{
            $fromEmail = 'info@takedaily.dk';
        }

        \Mail::send( 'emails.receipt',[
            'order' => $order,
            'layout' => 'layouts.mail',
            'locale' => $locale
        ], function ( $message ) use ( $mailEmail, $mailName, $locale, $fromEmail )
        {
            \App::setLocale( $locale );
            $message->from( $fromEmail, 'TakeDaily' );
            $message->to( $mailEmail, $mailName );
            $message->subject( trans( 'mails.order.receipt-subject' ) );
        } );

        return \Redirect::back()->withSuccess("The receipt has been sent!");
    }



    public function downloadReciept($id){

        $order = Order::find($id);
        $locale = $order->customer->getLocale();

        $file = 'reciept-'.$order->id.'.pdf';

        try {
            $pdf = \PDF::loadView( 'emails.receipt', [ 'order' => $order,
                'layout' => 'layouts.pdf',
                'locale' => $locale ] )
                ->setPaper( 'a4', 'portrait' );
            return $pdf->download($file);

        } catch (\Exception $exception) {
            \Log::error("PDF receipt error : " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

        }

    }

}