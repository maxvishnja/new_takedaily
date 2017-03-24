<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\PaymentsError;
use Illuminate\Http\Request;

class PaymentsErrorController extends Controller
{


    function index()
    {
        $errors = PaymentsError::orderBy('created_at', 'DESC')->get();

        return view('admin.payment_error.home', [
            'perrors' => $errors
        ]);
    }


}