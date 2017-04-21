<?php namespace App\Apricot\Helpers;

use App\Campaign;

class CampaignHelper
{

    public static function getPromoCampaign($code){


        $campaign = Campaign::where('partner_name', '=', $code)->first();

        if(!$campaign){

            return false;
        }

        if($campaign->country != \App::getLocale()){

            return false;
        }

        $camp['text'] = $campaign->description;

        if($campaign->color == ''){
            $camp['color'] = "88E2C4";
        } else{
            $camp['color'] = $campaign->color;
        }
        return $camp;

    }


}