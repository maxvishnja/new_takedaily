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



    function check($id)
    {
        $perror = PaymentsError::find($id);

        if( ! $perror )
        {
            return \Redirect::back()->withErrors("Payments Error (#{$id}) kunne ikke findes!");
        }

        $perror->check = 1;
        $perror->update();

        return \Redirect::action('Dashboard\PaymentsErrorController@index')->with('success', 'Payments checked');
    }


}