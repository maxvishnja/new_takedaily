<?php

namespace App\Http\Controllers\Dashboard;

use App\AlmostCustomers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlmostCustomersController extends Controller
{


    function index()
    {
        $almosts = AlmostCustomers::orderBy('created_at', 'DESC')->get();

        return view('admin.almost.home', [
            'almosts' => $almosts
        ]);
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