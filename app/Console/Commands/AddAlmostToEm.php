<?php

namespace App\Console\Commands;

use App\Apricot\Repositories\CustomerRepository;
use App\Apricot\Helpers\EmailPlatformApi;
use App\Customer;
use Illuminate\Console\Command;


class AddAlmostToEm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:add_almost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or update almost customers to Email Platform Api';

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


        $almosts = $repo->getAlmostCustomer();


        echo "Almost - ".count($almosts)." - ";


        $listid = 4988;

        $add_to_autoresponders = true;
        $skip_listcheck = true;

        $parser = new EmailPlatformApi();


        foreach($almosts as $almost){


            echo $almost->id." - ";

            $emailaddress = $almost->email;
            $mobile = '';
            $mobilePrefix = "";

            if($almost->location == "nl")
            {
                $country = 'NLD';
            }      else{
                $country = 'DNK';
            }

            $flowCompletion = \App\FlowCompletion::whereToken( $almost->token )->first();


            $vitamins['1'] = '';
            $vitamins['2'] = '';
            $vitamins['3'] = '';
            $vitamins['4'] = '';

            if($flowCompletion){

                $userData = $flowCompletion->user_data;

                $combinations = \App\Customer::calculateAlmostCombinations($userData);

                foreach ($combinations as $key=>$vitamin){
                    $s = $key+1;
                    $vitamins[$s] = \App\Apricot\Helpers\PillName::get(strtolower($vitamin));
                }


            }

            if($almost->token != ''){
                if ($almost->location == 'nl') {
                    $link = 'https://takedaily.nl/flow?token='.$almost->token;
                } else {

                    $link = 'https://takedaily.dk/flow?token='.$almost->token;
                }
            } else{
                $link = '';
            }

            $customfields  =  array (
                array (
                    'fieldid'  => 2,
                    'value'  =>  $almost->name),
                array (
                    'fieldid'  => 11,
                    'value'  =>  $country),
                array (
                    'fieldid'  => 2682,
                    'value'  =>  $country),
                array (
                    'fieldid'  => 2686,
                    'value'  =>  $vitamins['1']),
                array (
                    'fieldid'  => 2687,
                    'value'  =>  $vitamins['2']),
                array (
                    'fieldid'  => 2688,
                    'value'  =>  $vitamins['3']),
                array (
                    'fieldid'  => 2689,
                    'value'  =>  $vitamins['4']),
                array (
                    'fieldid'  => 2682,
                    'value'  =>  $link),
                array (
                    'fieldid'  => 2825,
                    'value'  =>  $almost->id),
                array (
                    'fieldid'  => 2669,
                    'value'  =>  'Almost'),

            );


            $result = $parser->AddSubscriberToList($listid, $emailaddress, $mobile, $mobilePrefix, $customfields, $add_to_autoresponders, $skip_listcheck);

            if(!is_array($result) and strstr($result,"Already subscribed to the list")){

                $subscriber = $parser->GetSubscriberDetails($emailaddress, $listid);
                if(is_array($subscriber)) {
                    if(isset($subscriber['subscriberid'])) {
                        $subscriberid = $subscriber['subscriberid'];

                        $status = $parser->Update_Subscriber($subscriberid, $emailaddress, $mobile, $listid, $customfields);

                    }
                }
            }

        }


    }
}