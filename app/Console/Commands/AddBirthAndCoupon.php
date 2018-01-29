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
            $customer->age_group = $customer->getAge();

            $order = $customer->orders()->whereNotNull('coupon')->first();
            if($order){
                $customer->coupon = $order->coupon;
            }


            $customer->save();



        }


        echo 'Ok';

    }
}
