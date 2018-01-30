<?php

namespace App\Console\Commands;

use App\Apricot\Repositories\CustomerRepository;
use Illuminate\Console\Command;

class AddBirthAndCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birth:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add age and coupon to customers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $repo = new CustomerRepository();

        $customers = $repo->all();

        foreach ($customers as $customer){

            $age = '';

            if($customer->getAge() <= 24){
                $age = 'group_1';
            }
            if($customer->getAge() > 24 and $customer->getAge() < 35){
                $age = 'group_2';
            }
            if($customer->getAge() > 34 and $customer->getAge() < 45){
                $age = 'group_3';
            }
            if($customer->getAge() > 44 and $customer->getAge() < 55){
                $age = 'group_4';
            }

            if($customer->getAge() > 54 and $customer->getAge() < 65){
                $age = 'group_5';
            }

            if($customer->getAge() > 64){
                $age = 'group_6';
            }


            $customer->setAgeGroup($age);
            

            $order = $customer->orders()->whereNotNull('coupon')->first();
            if($order){
                $customer->coupon = $order->coupon;
            }


            $customer->save();



        }


        echo 'Ok';

    }
}
