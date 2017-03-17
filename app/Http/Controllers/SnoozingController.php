<?php
namespace App\Http\Controllers;


use App\Customer;

use Illuminate\Http\Request;

class SnoozingController extends Controller
{

    public function checkSnooz($hash, $id, $email)
    {
        \Log::info('hash '.$hash);
        dd('11');

        return view('feedback.main');


    }



}