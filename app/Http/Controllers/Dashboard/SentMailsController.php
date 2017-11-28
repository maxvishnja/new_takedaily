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

}
