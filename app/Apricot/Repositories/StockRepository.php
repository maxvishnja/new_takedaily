<?php

namespace App\Apricot\Repositories;

use App\Item;
use App\Apricot\Interfaces\StockInterface;

class StockRepository implements StockInterface
{
    /**
     * @var Item
     */
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->item->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getItem($id)
    {
        return $this->item->find($id);
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    public function create(array $data)
    {
        $item = $this->fillItemObject($this->item, $data);
        return ($item->save()) ? $item : false;
    }

    /**
     * @param $itemId
     * @param array $data
     * @return bool|mixed
     */
    public function update($itemId, array $data)
    {
        $item = $this->item->find($itemId);
        $item = $this->fillItemObject($item, $data);
        return ($item->save()) ? $item : false;
    }

    /**
     * @param $itemId
     * @return bool
     */
    public function remove($itemId)
    {
        $item = $this->item->find($itemId);
        return ($item->delete()) ? : false;
    }

    /**
     * @param $object
     * @param array $data
     * @return mixed
     */
    private function fillItemObject($object, array $data)
    {
        if(isset($data['name'])) {
            $object->name = $data['name'];
        }

        if(isset($data['number'])) {
            $object->number = $data['number'];
        }

        if(isset($data['type'])) {
            $object->type = $data['type'];
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