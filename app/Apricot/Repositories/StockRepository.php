<?php

namespace App\Apricot\Repositories;

use App\Item;
use App\Apricot\Interfaces\StockInterface;
use App\Apricot\Repositories\OrderRepository;

class StockRepository implements StockInterface
{
    /**
     * @var Item
     */
    private $item;


    private $order;

    public function __construct(Item $item, OrderRepository $order)
    {
        $this->item = $item;
        $this->order = $order;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->item->all();
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getAllByType($type)
    {
        return $this->item->whereType($type)->get();
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
        $item = $this->getItem($itemId);
        $item = $this->fillItemObject($item, $data);
        return ($item->save()) ? $item : false;
    }

    /**
     * @param $itemId
     * @return bool
     */
    public function remove($itemId)
    {
        $item = $this->getItem($itemId);
        return ($item->delete()) ? : false;
    }

    /**
     * @return mixed
     */
    private function getPendingOrders()
    {
        return $this->order->getPaid()->shippable()->orderBy( 'created_at', 'DESC' )->with( 'customer.plan' )->get();
    }

    public function getCountPendingOrders()
    {
        return count($this->getPendingOrders());
    }

    /**
     * @return array
     */
    private function getVitaminsFromPendingOrders()
    {
        $orders = $this->getPendingOrders();
        $vtmns = [];

        foreach($orders as $order)
        {
            $vtmns[] = $order->customer->plan->vitamins;
        }

        return $vtmns;

    }

    /**
     * Calculate material quantity in all pending orders
     *
     * @param $itemId
     * @return int
     */
    public function calcOrdersMaterialQty($itemReqQty, $itemId)
    {
        $orders = $this->getPendingOrders();
        $item = $this->getItem($itemId);
        return $itemReqQty - count($orders);
    }

    public function checkUser()
    {
        if(Auth::user()->isAdmin())
        {
            return 'admin';
        }
        elseif(Auth::user()->isPacker())
        {
            return 'packer';
        }
    }

    /**
     * Calculate vitamin quantity in all pending orders
     *
     * @param $itemId
     * @param $itemReqQty
     * @return float|int
     */
    public function calcOrdersVitaminsQty($itemReqQty, $itemId)
    {
        $item = $this->getItem($itemId);
        $vitaminsFormOrders = $this->getVitaminsFromPendingOrders();

        $itemCount = [];
        foreach($vitaminsFormOrders as $vitamins)
        {
            foreach(\GuzzleHttp\json_decode($vitamins) as $v)
            {
                if($item->id == $v)
                {
                    $itemCount[] = $v;
                }
            }
        }

        return $itemReqQty - count($itemCount) * 28;

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

        if(isset($data['alert'])) {
            $object->alert = $data['alert'];
        }

        if(isset($data['status'])) {
            $object->status = $data['status'];
        }

        if(isset($data['price'])) {
            $object->price = $data['price'];
        }

        return $object;

    }
}