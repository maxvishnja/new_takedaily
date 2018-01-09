<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;


class ForecastController extends Controller
{


    function index()
    {


        return view('admin.forecast.home');
    }


    function indexPacker()
    {


        return view('packer.forecast.home');
    }


}
