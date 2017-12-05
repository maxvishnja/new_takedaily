<?php

namespace App\Apricot\Interfaces;

interface StockInterface
{
    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param $id
     * @return mixed
     */
    public function getItem($id);
}