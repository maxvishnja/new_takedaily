<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\CustomerRepository;
use App\Customer;
use App\Http\Controllers\Controller;
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

        return view('admin.stats.home', [
            'active_user' => $active_user
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
            if ($customer->isSubscribed()) {
                if (!empty($customer->getEmail()) and strstr($customer->getEmail(), "@")) {
                    $email_array[$i]['First Name'] = $customer->getFirstName();
                    $email_array[$i]['Last Name'] = $customer->getLastName();
                    $email_array[$i]['Phone'] = $customer->getPhone();
                    $email_array[$i]['Email Address'] = $customer->getEmail();
                    $i++;
                }

            }
        }

        \Excel::create('all_active_mails_'.$data['lang'], function ($excel) use ($email_array) {

            $excel->sheet('All users', function ($sheet) use ($email_array) {

                $sheet->fromArray($email_array, null, 'A1', true);

            });

        })->download('xls');

        return \Redirect::back();

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
                        if (!empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")) {
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
                            foreach ($plan->getVitamiPlan() as $vitamin){
                                $email_array[$i]['Supplements'] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)).", ";
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
                    } else{
                        $currency = "DKK";
                    }
                    $plans = Plan::where('currency','like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->get();
                    foreach ($plans as $plan) {
                        if (!empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")
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
                            foreach ($plan->getVitamiPlan() as $vitamin){
                                $email_array[$i]['Supplements'] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)).", ";
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