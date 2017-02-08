<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 03.02.17
 * Time: 15:41
 */

namespace app\Apricot\Helpers;

use App\Customer;
use App\Vitamin;

class AllVitamins
{

    public static function getCountVitamins () {

        $customers = Customer::all();
        $vitamins = [];
        foreach($customers as $customer){
            if(is_array($customer->plan->getVitamins())){
                for($i=0; $i<$customer->order_count; $i++){
                    $vitamins = array_merge($vitamins, $customer->plan->getVitamins());
                }
            }
        }

        $result = array_count_values($vitamins);
        arsort($result);
        $newvitamins = [];
        foreach($result as $key=>$value) {
            if (is_numeric($key)) {
                $vitamin_name = Vitamin::find($key);
                $newvitamins[] = ['name' => \App\Apricot\Helpers\PillName::get(strtolower($vitamin_name->code)), "count" => $value];
            }
        }

        return $newvitamins;

    }



}