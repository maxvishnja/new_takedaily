<?php
namespace App\Http\Controllers;


use App\Customer;

use Illuminate\Http\Request;

class SnoozingController extends Controller
{

    public function checkSnooz($hash, $id, $email)
    {

        \Debugbar::disable();

        \Log::info('hash '.$hash);

        $contents = \View::make('admin.snoozing.image');
        $response = \Response::make($contents, 200);
//        $response->header('Content-Type', 'image/jpeg');

        return $response;


    }



}