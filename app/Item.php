<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'stock_items';

    public static function calcStockItemsFromCreatedOrder($vitamins)
    {
        foreach(\GuzzleHttp\json_decode($vitamins) as $v)
        {
            $item = self::find($v);
            $item->qty = $item->qty - 28;
            $item->save();
        }

        $materials = Item::where('type', 'material')->get();

        foreach($materials as $mat)
        {
            $mat->qty = $mat->qty - 1;
            $mat->save();
        }

        return;
    }
    
    
}