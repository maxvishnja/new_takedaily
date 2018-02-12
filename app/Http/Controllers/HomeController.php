<?php


namespace App\Http\Controllers;

use Mbarwick83\Instagram\Instagram;
use App\Apricot\Repositories\ReviewRepository;
use App\Apricot\Interfaces\NutritionistRepositoryInterface;


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
     * @var NutritionistRepositoryInterface
     */
    private $nutritionist;

    public function __construct(
        Instagram $instagram,
        ReviewRepository $review,
        NutritionistRepositoryInterface $nutritionist
    )
    {
        $this->instagram = $instagram;
        $this->review = $review;
        $this->nutritionist = $nutritionist;
    }

    public function index()
    {
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
        $nutritionists = $this->nutritionist->getAllActive($locale);

        return view( 'home2', compact( 'instaLatestFour', 'reviews', 'nutritionists' ) );
    }
}