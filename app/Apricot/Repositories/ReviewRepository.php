<?php

namespace App\Apricot\Repositories;

use App\Review;

class ReviewRepository
{
    /**
     * @var Review
     */
    private $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function getById($id)
    {
        return $this->review->find($id);
    }

    public function all()
    {
        return $this->review->orderBy('created_at', 'DESC')->get();
    }
}