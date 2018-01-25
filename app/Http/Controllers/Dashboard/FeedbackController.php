<?php

namespace App\Http\Controllers\Dashboard;


use App\Customer;
use App\Feedback;
use App\Http\Controllers\Controller;
use App\Plan;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{


    function index()
    {

        $feedbacks = Feedback::orderBy('created_at', 'DESC')->get();

        return view('admin.feedback.main', [
            'feedbacks' => $feedbacks
        ]);
    }

    function show($id)
    {
        $feedback = Feedback::find($id);

        if( ! $feedback )
        {
            return \Redirect::back()->withErrors("Feedback (#{$id}) kunne ikke findes!");
        }


        return view('admin.feedback.show', [
            'feedback' => $feedback
        ]);
    }



    function destroy($id)
    {
        $feedback = Feedback::find($id);

        if( ! $feedback )
        {
            return \Redirect::back()->withErrors("Feedback (#{$id}) kunne ikke findes!");
        }


        $feedback->delete();


        return \Redirect::action('Dashboard\FeedbackController@index')->with('success', 'Feedback blev slettet.');

    }

}