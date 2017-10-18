<?php

namespace App\Apricot\Helpers;

use App\Customer;
use App\Order;
use App\Plan;


class CreateCsvMonths
{

    public static function storeAllCustomerMonthsToCsv($customers, $lang)
    {

//        ini_set('memory_limit', '200m');
//        ini_set('max_execution_time', 90);

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
                if ($customer->plan->subscription_rebill_at != null) {
                    $email_array[$i]['Nextpayment'] = \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->subscription_rebill_at)->format('d-m-Y');
                    if ($customer->plan->attempt > 0) {
                        $email_array[$i]['Real Nextpayment'] = \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getRebillAt())->subWeekday($customer->plan->attempt)->format('d-m-Y');
                    } else {
                        $email_array[$i]['Real Nextpayment'] = '';
                    }

                } else {

                    $email_array[$i]['Real Nextpayment'] = '';
                    $email_array[$i]['Nextpayment'] = '';

                }

                $email_array[$i]['Last PaymentDate'] = '';

                if ($customer->plan->last_rebill_date != null) {
                    $email_array[$i]['Last PaymentDate'] = $customer->plan->last_rebill_date;
                }

                $email_array[$i]['Vitamin 1'] = '';
                $email_array[$i]['Vitamin 2'] = '';
                $email_array[$i]['Vitamin 3'] = '';
                $email_array[$i]['Vitamin 4'] = '';

                if ($customer->plan->getVitamiPlan()) {
                    foreach ($customer->plan->getVitamiPlan() as $key => $vitamin) {
                        $s = $key + 1;
                        $email_array[$i]['Vitamin ' . $s] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)) . ", ";
                    }
                }


                $email_array[$i]['Unsubscribe reason'] = '';

                if ($customer->plan->unsubscribe_reason != '') {

                    if (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.0'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.0';
                    } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.1'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.1';
                    } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.2'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.2';
                    } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.3'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.3';
                    } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.4'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.4';
                    } elseif (strstr($customer->plan->unsubscribe_reason, trans('account.settings_cancel.reasons.5'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.5';
                    } else {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.other';
                    }

                }

                $email_array[$i]['Voucher'] = $customer->plan->getLastCoupon();
                $email_array[$i]['Amount'] = $customer->order_count;
                $email_array[$i]['Source'] = '';
                $email_array[$i]['Medium'] = '';
                $email_array[$i]['Campaign'] = '';

                if (count($customer->getMarketing()) > 0) {
                    foreach ($customer->getMarketing() as $market) {
                        $email_array[$i]['Source'] = $market->source;
                        $email_array[$i]['Medium'] = $market->medium;
                        $email_array[$i]['Campaign'] = $market->campaign;
                    }
                }

                $i++;
            }


        }

        \Excel::create('all_active_mails_months_'.$lang, function ($excel) use ($email_array) {

            $excel->sheet('All users', function ($sheet) use ($email_array) {

                $sheet->fromArray($email_array, null, 'A1', true);

            });

        })->store('xls', storage_path('excel/exports'));
    }

}