<?php

namespace App\Apricot\Interfaces;


interface NutritionistRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getAllActive();

    /**
     * @param $locale
     * @return mixed
     */
    public function getAllActiveByLocale($locale);
}