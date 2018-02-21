<?php

namespace App\Console\Commands;

use App\Apricot\Repositories\CustomerRepository;
use App\Customer;
use Illuminate\Console\Command;

class GetDuplicateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:duplicate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get duplicate users to CSV';

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

        $customers = $repo->getDuplicate();

        $email_array = [];
        $i = 0;

        foreach ($customers as $user) {



            $customer = Customer::find($user->customer_id);
            if($customer){
                $email_array[$i]['Name'] = $customer->getName();
                $email_array[$i]['E-mail'] = $customer->getEmail();
                $email_array[$i]['Duplicate address'] = $user->value;
                if ($customer->getLocale() == 'nl') {
                    $email_array[$i]['Country'] = 'Netherlands';
                } else {
                    $email_array[$i]['Country'] = 'Denmark';
                }


                $email_array[$i]['Created'] = \Date::createFromFormat('Y-m-d H:i:s', $customer->created_at)->format('d-m-Y H:i');


                $i++;
            }



        }

        \Excel::create('duplicate_customer', function ($excel) use ($email_array) {

            $excel->sheet('Duplicate users', function ($sheet) use ($email_array) {

                $sheet->fromArray($email_array, null, 'A1', true);

            });

        })->store('xls', storage_path('excel/exports'));
    }
}
