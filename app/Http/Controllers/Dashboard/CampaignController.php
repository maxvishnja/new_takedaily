<?php

namespace App\Http\Controllers\Dashboard;

use App\Campaign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignController extends Controller
{


    function index()
    {
        $campaigns = Campaign::orderBy('created_at', 'DESC')->get();

        return view('admin.campaign.home', [
            'campaigns' => $campaigns
        ]);
    }

    function create() {

        return view('admin.campaign.manage');
    }

    function store(Request $request ){

        $campaign = new Campaign();

        $campaign->partner_name = strtolower($request->get('partner_name'));
        $campaign->description = $request->get('description');
        $campaign->button_text = $request->get('button_text');
        $campaign->color = $request->get('color');
        $campaign->country = $request->get('country');


        $campaign->save();

        return \Redirect::action('Dashboard\CampaignController@index')->with('success', 'Campaign blev oprettet!');
    }


    function edit($id)
    {
        $campaign = Campaign::find($id);

        if( ! $campaign )
        {
            return \Redirect::back()->withErrors("Campaign (#{$id}) kunne ikke findes!");
        }

        return view('admin.campaign.manage', [
            'campaign' => $campaign,
        ]);
    }


    function update($id, Request $request ){

        $campaign =  Campaign::find($id);


        if ( !$campaign )
        {
            return \Redirect::back()->withErrors("Campaign (#{$id}) kunne ikke findes!");
        }

        $campaign->partner_name = strtolower($request->get('partner_name'));
        $campaign->description = $request->get('description');
        $campaign->button_text = $request->get('button_text');
        $campaign->color = $request->get('color');
        $campaign->country = $request->get('country');


        $campaign->save();

        return \Redirect::action('Dashboard\CampaignController@index')->with('success', 'Campaign blev opdateret!');
    }


    function destroy($id)
    {
        $campaign = Campaign::find($id);

        if ( !$campaign )
        {
            return \Redirect::back()->withErrors("Campaign (#{$id}) kunne ikke findes!");
        }

        $campaign->delete();

        return \Redirect::action('Dashboard\CampaignController@index')->with('success', 'Campaign blev slettet!');

    }

}