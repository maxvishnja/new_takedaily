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

    /**
     * 
     */
    public function getAll()
    {
        return $this->item->all();
    }

    /**
     * @param array $data
     */
    public function insert(array $data)
    {
        $item = $this->fillItemObject($this->item, $data);
        return ($item->save()) ? $item : false;
    }

    /**
     * @param $object
     * @param array $data
     */
    private function fillItemObject($object, array $data)
    {
        if(isset($data['name'])) {
            $object->name = $data['name'];
        }

        if(isset($data['number'])) {
            $object->number = $data['number'];
        }

        if(isset($data['description'])) {
            $object->description = $data['description'];
        }
        
        if(isset($data['reqQty'])) {
            $object->reqQty = $data['reqQty'];
        }

        if(isset($data['qty'])) {
            $object->qty = $data['qty'];
        }

        if(isset($data['price'])) {
            $object->price = $data['price'];
        }

        return $object;
        
    }
}