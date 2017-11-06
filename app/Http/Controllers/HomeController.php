<?php


namespace App\Http\Controllers;

use App\Apricot\Repositories\NutritionistRepository;
use App\Apricot\Repositories\ReviewRepository;
use Vinkla\Instagram\Instagram;


class HomeController extends Controller
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

    public function index()
    {

        // Instagram feed - latest four posts
        $locale = \App::getLocale();
        if($locale == 'da') {
            $instaFeed = $this->instagram->get('takedaily_dk');
        }else{
            $instaFeed = $this->instagram->get('takedaily_nl');
        }

        $instaLatestFour = array_slice($instaFeed, 0, 4, true);

        // Reviews
        $reviews = $this->review->all();

        // Nutritionists
        $nutritionists = $this->nutritionist->all();

        return view( 'home2', compact( 'instaLatestFour', 'reviews', 'nutritionists' ) );
    }
}