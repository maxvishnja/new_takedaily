<?php

namespace App\Apricot\Repositories;

use App\Nutritionist;
use app\Apricot\Interfaces\NutritionistRepositoryInterface;

class NutritionistRepository implements NutritionistRepositoryInterface
{
    /**
     * @var \App\Nutritionist
     */
    private $nutritionist;

    public function __construct(Nutritionist $nutritionist)
    {
        $this->nutritionist = $nutritionist;
    }

    public function all()
    {
        return $this->nutritionist->orderBy('created_at', 'DESC')->get();
    }

    public function getAllActive()
    {
        return $this->nutritionist->where('active', 1)->orderBy('created_at', 'DESC')->get();
    }

    public function getAllActiveByLocale($locale)
    {
        return $this->nutritionist->where(['active' => 1, 'locale' => $locale])->orderBy('created_at', 'DESC')->get();
    }

}