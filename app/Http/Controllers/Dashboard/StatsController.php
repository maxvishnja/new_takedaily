<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\CustomerRepository;
use App\Coupon;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Order;
use App\Plan;
use Illuminate\Http\Request;


class StatsController extends Controller
{

    private $repo;

    function __construct(CustomerRepository $repository)
    {
        $this->repo = $repository;
    }

    function index()
    {
        $active_user = $this->repo->allActive();
        $active_coupon = Coupon::orderBy( 'created_at', 'DESC' )->where( 'valid_to', '>=', date( 'Y-m-d' ) )->where('description','!=','Upsell discount')->get();

        return view('admin.stats.home', [
            'active_user' => $active_user,
            'active_coupon' => $active_coupon,
        ]);
    }

    /**
     * @param Request $request
     * @return int
     */
    function getData(Request $request)
    {

        if (\Request::ajax()) {
            $data = $request->all();
            switch ($data['stat_category']) {
                case 1:
                    return Customer::whereBetween('created_at', [$data['start-date'], $data['end-date']])->count();
                case 2:
                    return Plan::whereNotNull('subscription_snoozed_until')->whereBetween('subscription_snoozed_until', [$data['start-date'], $data['end-date']])->count();
                case 3:
                    $ordercount = Plan::whereBetween('updated_at', [$data['start-date'], $data['end-date']])->whereNull('subscription_snoozed_until')->whereNull('subscription_cancelled_at')->get();
                    $i = 0;
                    foreach ($ordercount as $order) {
                        $newdate = \Date::createFromFormat('Y-m-d H:i:s', $order->subscription_started_at)->addDays(28)->addWeekdays(5);

                        if ($newdate < \Date::createFromFormat('Y-m-d H:i:s', $order->subscription_rebill_at)) {
                            $i++;
                        }
                    }
                    return $i;
                case 4:
                    return Plan::whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start-date'], $data['end-date']])->count();
                case 5:
                    return Order::whereNotNull('repeat')->whereBetween('created_at', [$data['start-date'], $data['end-date']])->count();
                default:
                    return 0;
            }
        } else {
            return \Redirect::back()->withErrors("Access denied!");
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function exportCsv(Request $request)
    {
        $data = $request->all();

        $customers = $this->repo->allLocale($data['lang']);

        $email_array = [];
        $i = 0;
        foreach ($customers as $customer) {

            \App::setLocale($customer->getLocale());

                if (!empty($customer->getEmail()) and strstr($customer->getEmail(), "@") and $customer->plan->subscription_started_at != null) {
                    $email_array[$i]['Email'] = $customer->getEmail();
                    $email_array[$i]['Firstname'] = $customer->getFirstName();
                    $email_array[$i]['Lastname'] = $customer->getLastName();
                    $email_array[$i]['Phone'] = $customer->getPhone();

                    if ($customer->getGender() == 1) {
                        $email_array[$i]['Gender'] = 'male';
                    } else {
                        $email_array[$i]['Gender'] = 'female';
                    }

                    $email_array[$i]['Birth'] = $customer->getBirthday();

                    if ($customer->isSubscribed()) {
                        $email_array[$i]['Active'] = "Active";
                    } else {
                        $email_array[$i]['Active'] = "Not active";
                    }

                    if ($customer->plan->is_custom == 1) {
                        $email_array[$i]['Subscription type'] = 'PicknMix';
                    } else {
                        $email_array[$i]['Subscription type'] = 'Test';
                    }


                    $email_array[$i]['Signupdate'] = \Date::createFromFormat('Y-m-d H:i:s', $customer->created_at)->format('d-m-Y');
                    if ($customer->plan->subscription_rebill_at != null){
                        $email_array[$i]['Nextpayment'] = \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->subscription_rebill_at)->format('d-m-Y');
                        if($customer->plan->attempt > 0 ){
                            $email_array[$i]['Real Nextpayment'] = \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getRebillAt())->subWeekday($customer->plan->attempt)->format('d-m-Y');
                        } else{
                            $email_array[$i]['Real Nextpayment'] = '';
                        }

                     } else{

                        $email_array[$i]['Real Nextpayment'] = '';
                        $email_array[$i]['Nextpayment'] = '';

                    }

                    $email_array[$i]['Last PaymentDate'] = '';

                    if ($customer->plan->last_rebill_date != null){
                        $email_array[$i]['Last PaymentDate'] = $customer->plan->last_rebill_date;
                    }

                    $email_array[$i]['Vitamin 1'] = '';
                    $email_array[$i]['Vitamin 2'] = '';
                    $email_array[$i]['Vitamin 3'] = '';
                    $email_array[$i]['Vitamin 4'] = '';

                    if($customer->plan->getVitamiPlan()){
                        foreach ($customer->plan->getVitamiPlan() as $key=>$vitamin){
                            $s = $key+1;
                            $email_array[$i]['Vitamin '.$s] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)).", ";
                        }
                    }


                    $email_array[$i]['Unsubscribe reason'] = '';

                    if($customer->plan->unsubscribe_reason != ''){

                            if(strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.0'))){
                                    $email_array[$i]['Unsubscribe reason'] = 'Reasons.0';
                                }elseif(strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.1'))){
                                    $email_array[$i]['Unsubscribe reason'] = 'Reasons.1';
                                }elseif(strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.2'))){
                                    $email_array[$i]['Unsubscribe reason'] = 'Reasons.2';
                                }elseif(strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.3'))){
                                    $email_array[$i]['Unsubscribe reason'] = 'Reasons.3';
                                }elseif(strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.4'))){
                                    $email_array[$i]['Unsubscribe reason'] = 'Reasons.4';
                                }elseif(strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.5'))){
                                    $email_array[$i]['Unsubscribe reason'] = 'Reasons.5';
                                }else {
                                    $email_array[$i]['Unsubscribe reason'] = 'Reasons.other';
                            }

                        }

                    $email_array[$i][trans("attributes.user_data.age")] = '';
                    $email_array[$i][trans("attributes.user_data.skin")] = '';
                    $email_array[$i][trans("attributes.user_data.outside")] = '';
                    $email_array[$i][trans("attributes.user_data.pregnant")] = '';
                    $email_array[$i][trans("attributes.user_data.pregnancy.date")] = '';
                    $email_array[$i][trans("attributes.user_data.pregnancy.week")] = '';
                    $email_array[$i][trans("attributes.user_data.pregnancy.wish")] = '';
                    $email_array[$i][trans("attributes.user_data.diet")] = '';
                    $email_array[$i][trans("attributes.user_data.sports")] = '';
                    $email_array[$i][trans("attributes.user_data.lacks_energy")] = '';
                    $email_array[$i][trans("attributes.user_data.smokes")] = '';
                    $email_array[$i][trans("attributes.user_data.immune_system")] = '';
                    $email_array[$i][trans("attributes.user_data.vegetarian")] = '';
                    $email_array[$i][trans("attributes.user_data.joints")] = '';
                    $email_array[$i][trans("attributes.user_data.stressed")] = '';
                    $email_array[$i][trans("attributes.user_data.foods.fruits")] = '';
                    $email_array[$i][trans("attributes.user_data.foods.vegetables")] = '';
                    $email_array[$i][trans("attributes.user_data.foods.bread")] = '';
                    $email_array[$i][trans("attributes.user_data.foods.wheat")] = '';
                    $email_array[$i][trans("attributes.user_data.foods.dairy")] = '';
                    $email_array[$i][trans("attributes.user_data.foods.meat")] = '';
                    $email_array[$i][trans("attributes.user_data.foods.fish")] = '';
                    $email_array[$i][trans("attributes.user_data.foods.butter")] = '';
                    $email_array[$i][trans("attributes.user_data.priority")] = '';



                    $attributes = $customer->customerAttributes()->where('identifier', 'LIKE', 'user_data.%')->get();

                    foreach($attributes as $attribute) {
                        if($attribute->identifier != 'user_data.locale' and $attribute->identifier != 'user_data.gender' and $attribute->identifier != 'user_data.birthdate' and $attribute->identifier != ''){
                            $email_array[$i][trans("attributes.{$attribute->identifier}")]  =   $attribute->value;
                        }


                    }

                    $email_array[$i]['Voucher'] = $customer->plan->getLastCoupon();
                    $email_array[$i]['Amount'] = $customer->order_count;
                    $email_array[$i]['Source'] = '';
                    $email_array[$i]['Medium'] = '';
                    $email_array[$i]['Campaign'] = '';

                    if(count($customer->getMarketing()) > 0){
                        foreach ($customer->getMarketing() as $market) {
                            $email_array[$i]['Source'] = $market->source;
                            $email_array[$i]['Medium'] = $market->medium;
                            $email_array[$i]['Campaign'] = $market->campaign;
                        }
                    }

                    $i++;
                }


        }

        \Excel::create('all_active_mails_'.$data['lang'], function ($excel) use ($email_array) {

            $excel->sheet('All users', function ($sheet) use ($email_array) {

                $sheet->fromArray($email_array, null, 'A1', true);

            });

        })->download('xls');

        return \Redirect::back();

    }



    function cohortsToCsv(Request $request)
    {

        $data = $request->all();
        if($data){

            switch ($data['rate']) {

                case 4:

                    $users_array = [];
                    foreach(trans('flow.datepicker.months_long') as $key=>$month) {

                        $users_array[$month]['Month'] = $month;
                        $users_array[$month]['Signups'] = Plan::getSignups(sprintf('%02d', $key));
                        $users_array[$month]['0'] = '100%';
                        foreach (range($key, 12) as $y){
                            if($y >= $key and $y <= (int)date('m') ){
                                $users_array[$month][$y] = Plan::getCohorts(sprintf('%02d', $key),sprintf('%02d', $y));
                            }

                          }

                    }
                    \Excel::create('cohorts_month', function ($excel) use ($users_array) {

                        $excel->sheet('All users', function ($sheet) use ($users_array) {

                            $sheet->fromArray($users_array, null, 'A1', true);

                        });

                    })->download('xls');
                    return \Redirect::back();
                case 5:

                    $users_array = [];
                    foreach(range(0,date('W')-1) as $week) {

                        $users_array[$week]['Week'] = $week + 1;
                        $users_array[$week]['Signups'] = Plan::getSignupsWeek(sprintf('%02d', $week));
                        $users_array[$week]['0'] = '100%';
                        foreach (range(01, date('W')) as $y){
                            if(date('W')-$week >= $y){
                                $users_array[$week][$y] = Plan::getCohortsWeek(sprintf('%02d', $week),sprintf('%02d', $y));
                            }

                        }

                    }
                    \Excel::create('cohorts_week', function ($excel) use ($users_array) {

                        $excel->sheet('All users', function ($sheet) use ($users_array) {

                            $sheet->fromArray($users_array, null, 'A1', true);

                        });

                    })->download('xls');
                    return \Redirect::back();

                default:
                    return \Redirect::back()->withErrors("No data!");

            }

        }

    }


    function exportDateCoupon (Request $request){

        $data = $request->all();
         if ($data) {

             if($data['coupon'] == 1){

                 $orders = Order::where('repeat','=',$data['coupon'])->get();

             } else{
                 $orders = Order::where('coupon','=',$data['coupon'])->get();
             }



             if(count($orders) > 0){
                 $email_array = [];
                 $i = 0;
                        foreach ($orders as $order) {

                                    $email_array[$i]['First Name'] = $order->customer->getFirstName();
                                    $email_array[$i]['Last Name'] = $order->customer->getLastName();
                                    $email_array[$i]['Email Address'] = $order->customer->getEmail();
                                    $email_array[$i]['Created'] = \Date::createFromFormat('Y-m-d H:i:s', $order->customer->created_at)->format('d/m/Y H:i');
                                    $i++;


                        }


                 \Excel::create('users_coupon', function ($excel) use ($email_array) {

                     $excel->sheet('All users with coupon', function ($sheet) use ($email_array) {

                         $sheet->fromArray($email_array, null, 'A1', true);

                     });

                 })->download('xls');
                 return \Redirect::back();


             }

             return \Redirect::back()->withErrors("No items!");

         }

        return \Redirect::back()->withErrors("No data!");


    }




    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function exportCsvDate(Request $request)
    {

        $data = $request->all();
        if ($data) {

            switch ($data['csv-category']) {

                case 1:
                    $i = 0;
                    $customers = Customer::where('locale','like', $data['lang'])->whereBetween('created_at', [$data['start_date'], $data['end_date']])->get();
                    foreach ($customers as $customer) {
                        if (!empty($customer->getEmail()) and strstr($customer->getEmail(), "@")) {
                            $email_array[$i]['First Name'] = $customer->getFirstName();
                            $email_array[$i]['Last Name'] = $customer->getLastName();
                            $email_array[$i]['Phone'] = $customer->getPhone();
                            $email_array[$i]['Email Address'] = $customer->getEmail();
                            $i++;
                        }
                    }
                    if(isset($email_array)) {
                        \Excel::create('mails_from_' . $data['start_date'] . "_to_" . $data['end_date']."_".$data['lang'], function ($excel) use ($email_array) {

                            $excel->sheet('All users', function ($sheet) use ($email_array) {

                                $sheet->fromArray($email_array, null, 'A1', true);

                            });

                        })->download('xls');
                        return \Redirect::back();
                    }

                case 2:
                    $i = 0;
                    if($data['lang']=='nl'){
                        $currency = "EUR";
                    } else{
                        $currency = "DKK";
                    }
                    $plans = Plan::where('currency','like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->get();
                    foreach ($plans as $plan) {
                        if (!empty($plan->customer) and !empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")) {
                            $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                            $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                            $email_array[$i]['Phone'] = $plan->customer->getPhone();
                            if($plan->snoozing_at) {
                                $email_array[$i]['Sent postponing mail'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->snoozing_at)->format('j. M Y');
                            } else{
                                $email_array[$i]['Sent postponing mail'] = 'No data';
                            }
                            $email_array[$i]['Cancel date'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_cancelled_at)->format('j. M Y');
                            $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                            $email_array[$i]['Age'] = $plan->customer->getAge();
                            $email_array[$i]['Supplements'] = '';
                            if($plan->getVitamiPlan()){
                                foreach ($plan->getVitamiPlan() as $vitamin){
                                    $email_array[$i]['Supplements'] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)).", ";
                                 }
                             }
                            $email_array[$i]['Last coupon'] = $plan->getLastCoupon();
                            $i++;
                        }
                    }
                    if(isset($email_array)) {
                        \Excel::create('mails_from_' . $data['start_date'] . "_to_" . $data['end_date']."_".$data['lang'], function ($excel) use ($email_array) {

                            $excel->sheet('Unsubscribed users', function ($sheet) use ($email_array) {

                                $sheet->fromArray($email_array, null, 'A1', true);

                            });

                        })->download('xls');
                        return \Redirect::back();
                    }



                case 3:
                    $i = 0;
                    if($data['lang']=='nl'){
                        $currency = "EUR";
                        \App::setLocale('nl');
                    } else{
                        $currency = "DKK";
                        \App::setLocale('da');
                    }
                    $plans = Plan::where('currency','like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->get();
                    foreach ($plans as $plan) {
                        if (!empty($plan->customer) and !empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")
                            and $plan->unsubscribe_reason != ''
                            and !strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.0'))
                            and !strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.1'))
                            and !strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.2'))
                            and !strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.3'))
                            and !strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.4'))
                            and !strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.5'))

                        ) {
                            $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                            $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                            $email_array[$i]['Phone'] = $plan->customer->getPhone();
                            if($plan->snoozing_at) {
                                $email_array[$i]['Sent postponing mail'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->snoozing_at)->format('j. M Y');
                            } else{
                                $email_array[$i]['Sent postponing mail'] = 'No data';
                            }
                            $email_array[$i]['Cancel date'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_cancelled_at)->format('j. M Y');
                            $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                            $email_array[$i]['Age'] = $plan->customer->getAge();
                            $email_array[$i]['Supplements'] = '';
                            if($plan->getVitamiPlan()){
                                foreach ($plan->getVitamiPlan() as $vitamin){
                                    $email_array[$i]['Supplements'] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)).", ";
                                }
                            }
                            $email_array[$i]['Last coupon'] = $plan->getLastCoupon();
                            $email_array[$i]['Reason'] = $plan->unsubscribe_reason;
                            $i++;
                        }
                    }
                    if(isset($email_array)) {
                        \Excel::create('mails_from_' . $data['start_date'] . "_to_" . $data['end_date']."_".$data['lang'], function ($excel) use ($email_array) {

                            $excel->sheet('Unsubscribed users', function ($sheet) use ($email_array) {

                                $sheet->fromArray($email_array, null, 'A1', true);

                            });

                        })->download('xls');
                        return \Redirect::back();
                    }



                case 5:
                    $i = 0;
                    if($data['lang']=='nl'){
                        $currency = "EUR";
                        \App::setLocale('nl');
                    } else{
                        $currency = "DKK";
                        \App::setLocale('da');
                    }
                    $plans = Plan::where('currency','like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->get();
                    foreach ($plans as $plan) {
                        if (!empty($plan->customer) and !empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")
                            and strstr($plan->unsubscribe_reason,'from Dashboard')


                        ) {
                            $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                            $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                            $email_array[$i]['Phone'] = $plan->customer->getPhone();
                            if($plan->snoozing_at) {
                                $email_array[$i]['Sent postponing mail'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->snoozing_at)->format('j. M Y');
                            } else{
                                $email_array[$i]['Sent postponing mail'] = 'No data';
                            }
                            $email_array[$i]['Cancel date'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_cancelled_at)->format('j. M Y');
                            $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                            $email_array[$i]['Age'] = $plan->customer->getAge();
                            $email_array[$i]['Supplements'] = '';
                            if($plan->getVitamiPlan()){
                                foreach ($plan->getVitamiPlan() as $vitamin){
                                    $email_array[$i]['Supplements'] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)).", ";
                                }
                            }
                            $email_array[$i]['Last coupon'] = $plan->getLastCoupon();
                            $email_array[$i]['Reason'] = $plan->unsubscribe_reason;
                            $i++;
                        }
                    }
                    if(isset($email_array)) {
                        \Excel::create('mails_from_' . $data['start_date'] . "_to_" . $data['end_date']."_".$data['lang'], function ($excel) use ($email_array) {

                            $excel->sheet('Unsubscribed from dashboard', function ($sheet) use ($email_array) {

                                $sheet->fromArray($email_array, null, 'A1', true);

                            });

                        })->download('xls');
                        return \Redirect::back();
                    }


                case 4:
                    $i = 0;
                    if($data['lang']=='nl'){
                        $currency = "EUR";
                        \App::setLocale('nl');
                    } else{
                        $currency = "DKK";
                        \App::setLocale('da');
                    }
                    $newdate = \Date::now()->subWeeks($data['weeks']);
                    $plans = Plan::where('currency','like', $currency)->whereNull('subscription_cancelled_at')->where('subscription_started_at', '<',
                        \Date::createFromFormat('Y-m-d H:i:s', $newdate->addDay())->format('Y-m-d'))->get();


                    foreach ($plans as $plan) {
                        if (!empty($plan->customer) and !empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")

                        ) {
                            $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                            $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                            $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                            $email_array[$i]['Amount weeks'] = \Date::createFromFormat( 'Y-m-d H:i:s', $plan->subscription_started_at )->diffInWeeks();
                            $i++;
                        }
                    }
                    if(isset($email_array)) {
                        \Excel::create('mails_from_' . $data['start_date'] . "_to_" . $data['end_date']."_".$data['lang'], function ($excel) use ($email_array) {

                            $excel->sheet('Amount of weeks', function ($sheet) use ($email_array) {

                                $sheet->fromArray($email_array, null, 'A1', true);

                            });

                        })->download('xls');
                        return \Redirect::back();
                    }

                default:
                    return \Redirect::back()->withErrors("No data!");
            }


        } else {

            return \Redirect::back()->withErrors("Access denied!");
        }

    }



    public function getUnsubscribeReason(Request $request){

        $data = $request->all();

        if($data) {

            if ($data['lang'] == 'EUR') {
                \App::setLocale('nl');
            } else {
                \App::setLocale('da');
            }

            $count = 0;
            $reasons = array();
            $all = Plan::whereNotNull('subscription_cancelled_at')
                ->whereBetween('subscription_cancelled_at', [$data['start_dates'], $data['end_dates']])
                ->where('currency','=', $data['lang'])
                ->count();

            for($i=0; $i < 6; $i++){

                $count_res = Plan::whereNotNull('subscription_cancelled_at')
                    ->whereBetween('subscription_cancelled_at', [$data['start_dates'], $data['end_dates']])
                    ->where('unsubscribe_reason','like',trans('account.settings_cancel.reasons.'.$i.''))
                    ->where('currency','like',$data['lang'])
                    ->count();



                $reasons[]= ["name" => trans('account.settings_cancel.reasons.'.$i.''), "y"=>$count_res ];


                $count = $count + $count_res;
            }
            $reasons[6]= ["name" => 'Other reason', "y"=>$all - $count ];

          return $reasons;

        }

        return false;
    }

}