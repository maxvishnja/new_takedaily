<?php
namespace App\Http\Controllers;


use App\Customer;

use App\Snoozing;
use Illuminate\Http\Request;

class SnoozingController extends Controller
{

    public function checkSnooz($hash, $id, $email)
    {

        \Debugbar::disable();

        \Log::info('hash '.$hash);

        $mail = base64_decode($hash);

        $customer = Snoozing::where('email','=',$mail)->first();

        if($customer){

            $customer->open = \Date::now();
            $customer->save();
        }


        $contents = \View::make('admin.snoozing.image');
        $response = \Response::make($contents, 200);

        return $response;


    }



}