<?php

namespace App\Http\Controllers\Dashboard;


use App\Actions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActionsController extends Controller
{


    function index()
    {

        $actions = Actions::orderBy( 'created_at', 'DESC' )->get();

        return view( 'admin.actions.home', ['actions' => $actions]);
    }



    function create()
    {
        return view( 'admin.actions.manage' );
    }


    function store(Request $request) {

        $action = new Actions();

        $action->title = $request->get('title');
        $action->price_da = $request->get('price_da');
        $action->price_nl = $request->get('price_nl');
        $action->month = $request->get('month');
        $action->active = $request->get('active');


        $action->save();

        return \Redirect::action('Dashboard\ActionsController@index')->with('success', 'Action has added!');
    }

    function edit( $id )
    {
        $action = Actions::find($id);


        if ( !$action )
        {
            return \Redirect::back()->withErrors("Action (#{$id}) not found!");
        }

        return view('admin.actions.manage', [
            'action' => $action
        ]);
    }




    function update( Request $request, $id )
    {
        $action = Actions::find($id);


        if ( !$action )
        {
            return \Redirect::back()->withErrors("Action (#{$id}) not found!");
        }

        $action->title = $request->get('title');
        $action->price_da = $request->get('price_da');
        $action->price_nl = $request->get('price_nl');
        $action->month = $request->get('month');
        $action->active = $request->get('active');


        $action->save();

        return \Redirect::action('Dashboard\ActionsController@index')->with('success', 'Action has updated!');
    }



    function destroy( $id )
    {
        $faq = Faq::find( $id );

        if ( ! $faq )
        {
            return \Redirect::back()->withErrors( "Not found!" );
        }

        $faq->delete();

        return \Redirect::action( 'Dashboard\FaqController@index' )->with( 'success', 'Deleted' );
    }

}
