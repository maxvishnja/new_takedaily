<?php


namespace App\Http\Controllers;


use App\Campaign;

class CampaignController extends Controller
{


    public function getCampaign($code){

        $campaign = Campaign::where('partner_name', '=', $code)->first();

        if(!$campaign){

           return \Redirect::route( 'home' );
        }

        if($campaign->country != \App::getLocale()){

            return \Redirect::route( 'home' );
        }

        $faqs =  (new \App\Apricot\Repositories\FaqRepository())->get();

        $text = $campaign->description;

        return view('campaign', ['faqs' => $faqs, 'text' => $text]);

    }

}