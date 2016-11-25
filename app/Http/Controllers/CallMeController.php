<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CallMeController extends Controller
{
    public function post(Request $request)
    {
	    $this->validate($request, [
		    'phone'  => 'required',
		    'period' => 'required',
		    'date'   => 'required'
	    ] );

	    \App\Call::create( [
		    'phone'   => $request->get( 'phone' ),
		    'period'  => $request->get( 'period' ),
		    'call_at' => $request->get( 'date' ),
		    'status'  => 'requested'
	    ] );

	    return \Response::json( [ 'message' => trans( 'flow.call-me.success' ) ] );
    }
}
