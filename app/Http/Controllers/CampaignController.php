<?php


namespace App\Http\Controllers;


use App\Campaign;
use Mbarwick83\Instagram\Instagram;
use App\Apricot\Repositories\ReviewRepository;
use App\Apricot\Repositories\NutritionistRepository;

class CampaignController extends Controller
{
    /**
     * @var Instagram
     */
    private $instagram;

    /**
     * @var ReviewRepository
     */
    private $review;

    /**
     * @var NutritionistRepository
     */
    private $nutritionist;

    public function __construct(Instagram $instagram, ReviewRepository $review, NutritionistRepository $nutritionist)
    {
        $this->instagram = $instagram;
        $this->review = $review;
        $this->nutritionist = $nutritionist;
    }


    public function getCampaign($code){


        \Cookie::forget('campaign');

        $campaign = Campaign::where('partner_name', '=', $code)->first();

        if(!$campaign){

           return \Redirect::route( 'home' );
        }

        if($campaign->country != \App::getLocale()){

            return \Redirect::route( 'home' );
        }


        $locale = \App::getLocale();

        if($locale == 'da')
        {
            $user_id = env('INSTAGRAM_USER_ID_DK');
            $access_token = env('INSTAGRAM_ACCESS_TOKEN_DK');
        }
        else
        {
            $user_id = env('INSTAGRAM_USER_ID_NL');
            $access_token = env('INSTAGRAM_ACCESS_TOKEN_NL');
        }

        // Instagram feed - latest four posts
        $data = $this->instagram->get('v1/users/'.$user_id.'/media/recent', ['access_token' => $access_token]);
        $instaFeed = $data['data'];
        $instaLatestFour = array_slice($instaFeed, 0, 4, true);

        // Reviews
        $reviews = $this->review->getAllActiveByLocale($locale);

        // Nutritionists
        $nutritionists = $this->nutritionist->allActiveByLocale($locale);

        \Cookie::queue('campaign', $code, 60);

        $text = $campaign->description;
        $button = $campaign->button_text;

        if($campaign->color == ''){
            $color = "88E2C4";
        } else{
            $color = $campaign->color;
        }
        return view('campaign', compact( 'instaLatestFour', 'reviews', 'nutritionists', 'text', 'color', 'button' ) );

    }

}