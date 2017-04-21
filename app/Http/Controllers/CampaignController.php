<?php


namespace App\Http\Controllers;


use App\Campaign;

class CampaignController extends Controller
{


    public function getCampaign($code){


        \Cookie::forget('campaign');

        $campaign = Campaign::where('partner_name', '=', $code)->first();

        if(!$campaign){

           return \Redirect::route( 'home' );
        }

        if($campaign->country != \App::getLocale()){

            return \Redirect::route( 'home' );
        }



        $faqs =  (new \App\Apricot\Repositories\FaqRepository())->get();

//        if($campaign->partner_name == 'oa') {
//            $color = "#FFFF66";
//            } else{
//            $color = "#88E2C4";
//        }

        \Cookie::queue('campaign', $code, 60);

        $text = $campaign->description;
        $button_text = $campaign->button_text;

        if($campaign->color == ''){
            $color = "88E2C4";
        } else{
            $color = $campaign->color;
        }
        return view('campaign', ['faqs' => $faqs, 'text' => $text, 'color'=> $color, 'button' => $button_text]);

    }

}