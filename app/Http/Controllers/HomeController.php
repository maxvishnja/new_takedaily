<?php


namespace App\Http\Controllers;

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

    public function __construct(Instagram $instagram, ReviewRepository $review)
    {
        $this->instagram = $instagram;
        $this->review = $review;
    }

    public function index()
    {

        // instagram feed - latest four posts
        $instaFeed = $this->instagram->get('takedaily_dk');
        $instaLatestFour = array_slice($instaFeed, 0, 4, true);

        // reviews
        $reviews = $this->review->all();

//        return $instaLatestFour;

        //todo: trustpilot review

        return view( 'home2', compact( 'instaLatestFour', 'reviews' ) );
    }
}