<?php

namespace App\Console\Commands;

use App\Customer;
use Illuminate\Console\Command;
use Jenssegers\Date\Date;

class UpdatePregnancyWeeks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:pregnancy-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update pregnancy weeks';

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
        $customersWithBirthdates = Customer::select('customers.*', 'customer_attributes.value as pregnancy_date')->leftJoin('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')->where('customer_attributes.identifier', 'user_data.pregnancy.date')->get();

        foreach($customersWithBirthdates as $customer)
        {
			$customer->setCustomerAttribute('user_data.pregnancy.week', (new Date($customer->pregnancy_date))->diffInWeeks(), false);
        }
    }
}
