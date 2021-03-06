<?php

namespace App\Http\Controllers\Dashboard;

use App\AlmostCustomers;
use App\Apricot\Repositories\CustomerRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;

class AlmostCustomersController extends Controller
{


    private $repo;

    function __construct(CustomerRepository $repository)
    {
        $this->repo = $repository;
    }


    function index()
    {

        $almosts = $this->repo->getAlmostCustomer();

        return view('admin.almost.home', [
            'almosts' => $almosts
        ]);
    }



    function sendAll(){


        $almosts = $this->repo->getAlmostCustomerNotSend();

        foreach($almosts as $almost){

            \App::setLocale($almost->location);

            $mailEmail = $almost->email;
            $mailName = 'TakeDaily';
            $name = $almost->name;

            if ($almost->location == 'nl') {

                $fromEmail = 'info@takedaily.nl';
                $link = 'https://takedaily.nl/flow?token='.$almost->token;

            } else {

                $fromEmail = 'info@takedaily.dk';
                $link = 'https://takedaily.dk/flow?token='.$almost->token;
            }

            $almost->sent = 1;

            $newalmost = AlmostCustomers::find($almost->id);
            $newalmost->sent = 1;
            $newalmost->save();

            \Mail::send('emails.almost-customers', ['locale' => $almost->location, 'name' => $name, 'link' => $link], function (Message $message) use ($mailEmail, $mailName, $fromEmail) {
                $message->from($fromEmail, 'TakeDaily');
                $message->to($mailEmail, $mailName);
                $message->subject(trans('mails.almost-subject'));
            });

            continue;
        }

        return \Redirect::action('Dashboard\AlmostCustomersController@index')->with('success', 'All email have been sent!');

    }



    function sendOne($id){

            $almost = AlmostCustomers::find($id);

            $mailEmail = $almost->email;
            $mailName = 'TakeDaily';
            $name = $almost->name;

            if ($almost->location == 'nl') {

                $fromEmail = 'info@takedaily.nl';
                $link = 'https://takedaily.nl/flow?token='.$almost->token;
            } else {

                $fromEmail = 'info@takedaily.dk';
                $link = 'https://takedaily.dk/flow?token='.$almost->token;
            }

            $almost->sent = 1;
            $almost->save();

            \Mail::send('emails.almost-customers', ['locale' => $almost->location, 'name' => $name, 'link' => $link], function (Message $message) use ($mailEmail, $mailName, $fromEmail) {
                $message->from($fromEmail, 'TakeDaily');
                $message->to($mailEmail, $mailName);
                $message->subject(trans('mails.almost-subject'));
            });



        return \Redirect::action('Dashboard\AlmostCustomersController@index')->with('success', 'Email sent!');

    }


    function getCsv(){

        $almostAll = $this->repo->getAlmostCustomer();

        $email_array = [];
        $i = 0;

        foreach ($almostAll as $customer) {

            $email_array[$i]['Name'] = $customer->name;
            $email_array[$i]['E-mail'] = $customer->email;
            if ($customer->location == 'nl') {
                $email_array[$i]['Country'] = 'Netherlands';
            } else {
                $email_array[$i]['Country'] = 'Denmark';
            }

            $email_array[$i]['Vitamin 1'] = '';
            $email_array[$i]['Vitamin 2'] = '';
            $email_array[$i]['Vitamin 3'] = '';
            $email_array[$i]['Vitamin 4'] = '';

            $flowCompletion = \App\FlowCompletion::whereToken( $customer->token )->first();

            if($flowCompletion){

                $userData = $flowCompletion->user_data;

                $combinations = \App\Customer::calculateAlmostCombinations($userData);

                foreach ($combinations as $key=>$vitamin){
                    $s = $key+1;
                    $email_array[$i]['Vitamin '.$s] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin));
                }


            }


            if($customer->token != ''){
                if ($customer->location == 'nl') {
                    $link = 'https://takedaily.nl/flow?token='.$customer->token;
                } else {

                    $link = 'https://takedaily.dk/flow?token='.$customer->token;
                }
            } else{
                $link = '';
            }

            $email_array[$i]['Test link'] = $link;



                $email_array[$i]['Created'] = \Date::createFromFormat('Y-m-d H:i:s', $customer->created_at)->format('d-m-Y H:i');


                $i++;


        }

        \Excel::create('almost_customers', function ($excel) use ($email_array) {

            $excel->sheet('Almost users', function ($sheet) use ($email_array) {

                $sheet->fromArray($email_array, null, 'A1', true);

            });

        })->download('xls');

        return \Redirect::back();
    }


    function destroy($id)
    {
        $almost = AlmostCustomers::find($id);

        if ( !$almost )
        {
            return \Redirect::back()->withErrors("Customers (#{$id}) kunne ikke findes!");
        }

        $almost->delete();

        return \Redirect::action('Dashboard\AlmostCustomersController@index')->with('success', 'Almost customers blev slettet!');

    }

}