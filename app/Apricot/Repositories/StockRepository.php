<?php

namespace App\Apricot\Repositories;

use App\Item;
use App\Apricot\Interfaces\StockInterface;

class StockRepository implements StockInterface
{
    /**
     * @var App\Item
     */
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function getAll()
    {
        return $this->item->all();
    }

    /**
     * @param array $data
     */
    public function insert(array $data)
    {
        $item = $this->fillItemObject($data);
        return ($item->save()) ? $item : false;
    }

    /**
     * @param array $data
     */
    private function fillItemObject(array $data)
    {
        if(isset($data['name'])) {
            $this->item->name = $data['name'];
        }
    }
}