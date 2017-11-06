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

}