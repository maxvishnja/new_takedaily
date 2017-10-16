<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 13.10.17
 * Time: 8:59
 */

namespace App\Console\Commands;


use App\Customer;
use App\Nutritionist;
use App\Plan;
use Illuminate\Console\Command;

class DebugCommand extends Command
{
    protected $signature = 'td:debug';

    public function handle()
    {
        /** @var Customer $customer */
        $customer = Customer::find(7);

        /** @var Plan $plan */
        $plan = $customer->plan;


        /** @var Nutritionist $nutritionist */
        $nutritionist = $plan->nutritionist;

        echo "<pre>";
        var_dump($nutritionist->toArray());
        echo "</pre>";
    }
}