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

    public function getAllActiveByLocale($locale)
    {
        return $this->review->where(['locale' => $locale, 'active' => 1])->get();
    }

    public function insert($data)
    {
        $review = $this->fillReviewObject($this->review, $data);

        return ($review->save()) ? $review : false;
    }

    public function update($reviewId, array $data)
    {
        $review = $this->getById($reviewId);
        $review = $this->fillReviewObject($review, $data);
        return ($review->save()) ? $review : false;
    }

    private function fillReviewObject($object, array $data)
    {
        if(isset($data['name']))
        {
            $object->name = $data['name'];
        }

        if(isset($data['age']))
        {
            $object->age = $data['age'];
        }

        if(isset($data['review']))
        {
            $object->review = $data['review'];
        }

        if(isset($data['locale']))
        {
            $object->locale = $data['locale'];
        }

        if(isset($data['active']))
        {
            $object->active = $data['active'];
        }

        return $object;
    }
}