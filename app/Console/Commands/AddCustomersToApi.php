<?php

namespace App\Console\Commands;

use App\Apricot\Repositories\CustomerRepository;
use App\Apricot\Helpers\EmailPlatformApi;
use App\Coupon;
use App\Customer;
use Illuminate\Console\Command;


class AddCustomersToApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or update customers to Email Platform Api';

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

        $customers = $repo->allEm();

        echo "All - ".count($customers)." - ";


        $listid = 4988;

        $add_to_autoresponders = true;
        $skip_listcheck = true;

        $parser = new EmailPlatformApi();

        $i =0;

        foreach($customers as $customer){


            echo $customer->id." - ";

            \App::setLocale($customer->getLocale());

            $emailaddress = $customer->getEmail();
            $mobile = $customer->getPhone();


            if($customer->getLocale() == 'nl'){
                $mobilePrefix = "31";
            } else{
                $mobilePrefix = "45";
            }

            if ($customer->getGender() == 1) {
                $gender = 'male';
            } else {
                $gender = 'female';
            }

            $source = '';
            $medium = '';
            $campaign = '';


            if (count($customer->getMarketing()) > 0) {
                try{
                    foreach ($customer->getMarketing() as $market) {
                        $source = $market->source;
                        $medium = $market->medium;
                        $campaign = $market->campaign;
                    }

                } catch (\Exception $exception) {

                    \Log::error("Foreach error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

                }
            }
            $winback = '';


            if ($customer->isSubscribed()) {
                if($customer->plan->trial == 1){
                    $active = "Trial";
                }else {
                    $active = "Active";
                }
            } else {
                $active = "Not active";
                $hash = base64_encode($customer->id);
                if ($customer->getLocale() == "nl"){
                    $winback = "https://takedaily.nl/winback/".$hash;
                }else{
                    $winback = "https://takedaily.dk/winback/".$hash;
                }


            }


            if($customer->getLocale() == "nl")
            {
                $country = 'NLD';
            }      else{
                $country = 'DNK';
            }

            $unsubscribe = '';
            $discount100 = '';
            $discount50 = '';
            $discount20 = '';

            $coupon100 = Coupon::where('currency',$customer->plan->currency)->where('automatic_id','100first')->first();

            if($coupon100){
                $discount100 = $coupon100->code;
            }

            $coupon50 = Coupon::where('currency',$customer->plan->currency)->where('automatic_id','50first')->first();

            if($coupon50){
                $discount50 = $coupon50->code;
            }

            $coupon20 = Coupon::where('currency',$customer->plan->currency)->where('automatic_id','20sub')->first();

            if($coupon20){
                $discount20 = $coupon20->code;
            }






            if ($customer->plan->subscription_cancelled_at != null) {
                $unsubscribe = \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->subscription_cancelled_at)->format('d-m-Y');
            }


            $lastpaymentdate = '';

            if ($customer->plan->last_rebill_date != null) {
                $lastpaymentdate = \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->last_rebill_date)->format('d-m-Y');
            }

            $nextpaymentdate = '';
            $nextshipmentdate = '';

            if ($customer->plan->subscription_rebill_at != null) {
                $nextpaymentdate = \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->subscription_rebill_at)->format('d-m-Y');

                $nextshipmentdate = \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->subscription_rebill_at)->addDay()->format('d-m-Y');

            }


            $datetime1 = new \DateTime($customer->created_at);

            if ($customer->plan->subscription_cancelled_at != null) {
                $datetime2 = new \DateTime($customer->plan->subscription_cancelled_at);
            } else{
                $datetime2 = \Date::now();
            }
            $interval = $datetime1->diff($datetime2);

            $vitamins['1'] = '';
            $vitamins['2'] = '';
            $vitamins['3'] = '';
            $vitamins['4'] = '';



            if ($customer->plan->getVitamiPlan() and count($customer->plan->getVitamiPlan()) > 1) {

                try{
                    foreach ($customer->plan->getVitamiPlan() as $key => $vitamin) {
                        $s = $key + 1;
                        $vitamins[$s] = \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code));
                    }

                } catch (\Exception $exception) {

                    \Log::error("Foreach 2 error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

                }
            }

            $reason = '';
            $unsubReason = '';

            if ($customer->plan->unsubscribe_reason != '') {

                $reason = $customer->plan->unsubscribe_reason;

                if (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.0'))) {
                    $unsubReason = '0';
                } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.1'))) {
                    $unsubReason = '1';
                } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.2'))) {
                    $unsubReason = '2';
                } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.3'))) {
                    $unsubReason = '3';
                } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.4'))) {
                    $unsubReason = '4';
                } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.5'))) {
                    $unsubReason = '5';
                } else {
                    $unsubReason = 'other';
                }
            }

            if ($customer->plan->is_custom == 1) {
                $s_type = 'PicknMix';
            } else {
                $s_type= 'Test';
            }
            $attributes = $customer->customerAttributes()->where('identifier', 'LIKE', 'user_data.%')->get();

            $choice = '';

            if($attributes and count($attributes) > 1){


                try {

                    foreach($attributes as $attribute){

                        if($attribute->identifier != 'user_data.gender' and $attribute->identifier !='user_data.age' and $attribute->identifier !='user_data.locale' and $attribute->identifier !='user_data.birthdate' and $attribute->value != ''){
                            $choice.=$attribute->value.',';
                        }
                    }

                } catch (\Exception $exception) {

                    \Log::error("Foreach 3 error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

                }


            }

            if($customer->plan->subscription_started_at != null){
                $latest_date = $customer->plan->subscription_started_at;
            } else{
                $latest_date = $customer->created_at;
            }

            $lastOrder = $customer->orders()->where('state','sent')->latest()->first();


            $lastOrderDate = '';

            if($lastOrder){
                $lastOrderDate = \Date::createFromFormat('Y-m-d H:i:s', $lastOrder->updated_at)->format('d-m-Y');
            }

            $age = 0;

            if($customer->getAge()){
                $age = $customer->getAge();
            }


            if($i%10 == 0){
                $testgroup = 1;
            }else{
                $testgroup = 0;
            }

            try {
                $customfields  =  array (
                    array (
                        'fieldid'  => 2,
                        'value'  =>  $customer->getFirstName()),
                    array (
                        'fieldid'  => 3,
                        'value'  =>  $customer->getLastName()),
                    array (
                        'fieldid'  => 12,
                        'value'  =>  $gender),

                    array (
                        'fieldid'  => 2667,
                        'value'  =>  $age),
                    array (
                        'fieldid'  => 2668,
                        'value'  =>  $customer->getBirthday()),
                    array (
                        'fieldid'  => 4,
                        'value'  =>  $customer->getPhone()),
                    array (
                        'fieldid'  => 2583,
                        'value'  =>  $customer->plan->getLastCoupon()),
                    array (
                        'fieldid'  => 2585,
                        'value'  =>  $source),
                    array (
                        'fieldid'  => 2586,
                        'value'  =>  $medium),
                    array (
                        'fieldid'  => 2587,
                        'value'  =>  $campaign),
                    array (
                        'fieldid'  => 11,
                        'value'  =>  $country),
                    array (
                        'fieldid'  => 2669,
                        'value'  =>  $active),
                    array (
                        'fieldid'  => 2670,
                        'value'  =>  \Date::createFromFormat('Y-m-d H:i:s', $customer->created_at)->format('d-m-Y')),
                    array (
                        'fieldid'  => 2693,
                        'value'  =>  \Date::createFromFormat('Y-m-d H:i:s', $customer->created_at)->format('H:i:s')),
                    array (
                        'fieldid'  => 2671,
                        'value'  =>  \Date::createFromFormat('Y-m-d H:i:s', $latest_date)->format('d-m-Y')),
                    array (
                        'fieldid'  => 2694,
                        'value'  =>  \Date::createFromFormat('Y-m-d H:i:s', $latest_date)->format('H:i:s')),
                    array (
                        'fieldid'  => 2672,
                        'value'  =>  $unsubscribe),
                    array (
                        'fieldid'  => 2673,
                        'value'  =>  $unsubscribe),
                    array (
                        'fieldid'  => 2674,
                        'value'  =>  $lastpaymentdate),
                    array (
                        'fieldid'  => 2675,
                        'value'  =>  $nextpaymentdate),
                    array (
                        'fieldid'  => 2676,
                        'value'  =>  $lastOrderDate),
                    array (
                        'fieldid'  => 2677,
                        'value'  =>  $nextshipmentdate),
                    array (
                        'fieldid'  => 2678,
                        'value'  =>  ''),
                    array (
                        'fieldid'  => 2679,
                        'value'  =>  $winback),
                    array (
                        'fieldid'  => 2680,
                        'value'  =>  ''),
                    array (
                        'fieldid'  => 2681,
                        'value'  =>  ''),
                    array (
                        'fieldid'  => 2682,
                        'value'  =>  ''),
                    array (
                        'fieldid'  => 2683,
                        'value'  =>  $interval->days),
                    array (
                        'fieldid'  => 2684,
                        'value'  =>  $nextshipmentdate),
                    array (
                        'fieldid'  => 2685,
                        'value'  =>  ''),
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
                        'fieldid'  => 3235,
                        'value'  =>  $unsubReason),
                    array (
                        'fieldid'  => 2584,
                        'value'  =>  $customer->order_count),
                    array (
                        'fieldid'  => 2690,
                        'value'  =>  $reason),
                    array (
                        'fieldid'  => 2695,
                        'value'  =>  $s_type),
                    array (
                        'fieldid'  => 2692,
                        'value'  =>  $choice),
                    array (
                        'fieldid'  => 5036,
                        'value'  =>  $discount50),
                    array (
                        'fieldid'  => 5037,
                        'value'  =>  $discount100),
                    array (
                        'fieldid'  => 3737,
                        'value'  =>  $testgroup),
                    array (
                        'fieldid'  => 5038,
                        'value'  =>  $discount20),
                    array (
                        'fieldid'  => 2825,
                        'value'  =>  $customer->id),
                );

            } catch (\Exception $exception) {

                \Log::error("Create fields error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

            }



            $result = $parser->AddSubscriberToList($listid, $emailaddress, $mobile, $mobilePrefix, $customfields, $add_to_autoresponders, $skip_listcheck);

            if(!is_array($result) and strstr($result,"Already subscribed to the list")){

                $subscriber = $parser->GetSubscriberDetails($emailaddress, $listid);
                // print_r ($subscriber);
                if(is_array($subscriber)){
                    if(isset($subscriber['subscriberid'])){
                        $subscriberid = $subscriber['subscriberid'];

                        $status = $parser->Update_Subscriber($subscriberid, $emailaddress, $mobile, $listid, $customfields);
                    }

                }

            }

            $i++;

        }

    }
}