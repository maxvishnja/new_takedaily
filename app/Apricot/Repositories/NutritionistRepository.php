<?php

namespace App\Apricot\Repositories;

use App\Nutritionist;

class NutritionistRepository
{
    public function all()
    {
        return Nutritionist::orderBy('created_at', 'DESC')->get();
    }

}