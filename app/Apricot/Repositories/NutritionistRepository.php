<?php

namespace App\Apricot\Repositories;

use App\Nutritionist;

class NutritionistRepository
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

    public function allActive()
    {
        return $this->nutritionist->where('active', 1)->orderBy('created_at', 'DESC')->get();
    }

    public function allActiveByLocale($locale)
    {
        return $this->nutritionist->where(['active' => 1, 'locale' => $locale])->orderBy('created_at', 'DESC')->get();
    }

}