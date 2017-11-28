<?php

namespace App\Http\Controllers\Dashboard;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class SentMailsController extends Controller
{



    function index()
    {


        return view('admin.sent_mails.home');
    }

    function getDate(){


        $dateArray = [];

        foreach(range(6,0) as $i){

            $dateArray [] = \Date::now()->subDay($i)->format('d/m/Y');

        }

       return $dateArray;


    }

}
