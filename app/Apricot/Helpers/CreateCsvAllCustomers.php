<?php
namespace App\Apricot\Helpers;
use App\Customer;
use App\Order;
use App\Plan;
use App\Setting;



class CreateCsvAllCustomers
{
    public static function storeAllCustomerToCsv($customers, $lang)
    {

        \Log::info('Start in function create CSV ' . $lang);
        $email_array = [];
        $i = 0;
        foreach ($customers as $plan) {
            try {
                \Log::info('Make ' . $plan->id);

                \App::setLocale($plan->customer->getLocale());

                $email_array[$i]['Firstname'] = $plan->customer->getFirstName();
                $email_array[$i]['Email'] = $plan->customer->getEmail();
                $email_array[$i]['Phone'] = $plan->customer->getPhone();
                if ($plan->customer->getGender() == 1) {
                    $email_array[$i]['Gender'] = 'male';
                } else {
                    $email_array[$i]['Gender'] = 'female';
                }
                $email_array[$i]['Birth'] = $plan->customer->getBirthday();
                if ($plan->customer->isSubscribed()) {
                    $email_array[$i]['Active'] = "Active";
                } else {
                    $email_array[$i]['Active'] = "Not active";
                }
                if ($plan->is_custom == 1) {
                    $email_array[$i]['Subscription type'] = 'PicknMix';
                } else {
                    $email_array[$i]['Subscription type'] = 'Test';
                }
                $email_array[$i]['Signupdate'] = \Date::createFromFormat('Y-m-d H:i:s', $plan->created_at)->format('d-m-Y');
                if ($plan->subscription_rebill_at != null) {
                    $email_array[$i]['Nextpayment'] = \Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_rebill_at)->format('d-m-Y');
                } else {
                    $email_array[$i]['Nextpayment'] = '';
                }
                $email_array[$i]['Last PaymentDate'] = '';
                if ($plan->last_rebill_date != null) {
                    $email_array[$i]['Last PaymentDate'] = $plan->last_rebill_date;
                }
                $email_array[$i]['Unsubscribe date'] = '';
                if ($plan->subscription_cancelled_at != null) {
                    $email_array[$i]['Unsubscribe date'] = \Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_cancelled_at)->format('d-m-Y');
                }
                $email_array[$i]['Unsubscribe reason'] = '';
                if ($plan->unsubscribe_reason != '') {
                    if (strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.0'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.0';
                    } elseif (strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.1'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.1';
                    } elseif (strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.2'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.2';
                    } elseif (strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.3'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.3';
                    } elseif (strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.4'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.4';
                    } elseif (strstr($plan->unsubscribe_reason, trans('account.settings_cancel.reasons.5'))) {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.5';
                    } else {
                        $email_array[$i]['Unsubscribe reason'] = 'Reasons.other';
                    }
                }
                $email_array[$i]['Voucher'] = $plan->getLastCoupon();
                $email_array[$i]['Amount'] = $plan->customer->order_count;
                $email_array[$i]['Source'] = '';
                $email_array[$i]['Medium'] = '';
                $email_array[$i]['Campaign'] = '';
                if (count($plan->customer->getMarketing()) > 0) {
                    foreach ($plan->customer->getMarketing() as $market) {
                        $email_array[$i]['Source'] = $market->source;
                        $email_array[$i]['Medium'] = $market->medium;
                        $email_array[$i]['Campaign'] = $market->campaign;
                    }
                }
                try {
                    $email_array[$i]['Hvilken hudfarve matcher din bedst?'] = $plan->customer->getCustomerAttribute('user_data.skin');
                    $email_array[$i]['Er du udenfor i dagslys hver dag i mindst 15-30 minutter?'] = $plan->customer->getCustomerAttribute('user_data.outside');
                    $email_array[$i]['Er du gravid, eller drømmer du om at blive det?'] = $plan->customer->getCustomerAttribute('user_data.pregnant');
                    $email_array[$i]['Er du på slankekur?'] = $plan->customer->getCustomerAttribute('user_data.diet');
                    $email_array[$i]['Hvor meget og hvor ofte motionerer du?'] = $plan->customer->getCustomerAttribute('user_data.sports');
                    $email_array[$i]['Føler du dig stresset?'] = $plan->customer->getCustomerAttribute('user_data.stressed');
                    $email_array[$i]['Føler du dig træt og mangler du energi?'] = $plan->customer->getCustomerAttribute('user_data.lacks_energy');
                    $email_array[$i]['Hvordan fungerer dit immunforsvar i øjeblikket?'] = $plan->customer->getCustomerAttribute('user_data.immune_system');
                    $email_array[$i]['Ryger du?'] = $plan->customer->getCustomerAttribute('user_data.smokes');
                    $email_array[$i]['Hvor langt er du, eller ønsker du at blive gravid?'] = $plan->customer->getCustomerAttribute('pregnancy.week');
                    $email_array[$i]['Er du vegetar/veganer?'] = $plan->customer->getCustomerAttribute('user_data.vegetarian');
                    $email_array[$i]['Har du ømme muskler eller ondt i dine led?'] = $plan->customer->getCustomerAttribute('user_data.joints');
                    $email_array[$i]['Hvor mange grøntsager spiser du om dagen?'] = $plan->customer->getCustomerAttribute('user_data.foods.vegetables');
                    $email_array[$i]['Hvor meget frugt spiser du om dagen?'] = $plan->customer->getCustomerAttribute('user_data.foods.fruits');
                    $email_array[$i]['Hvor mange skiver brød spiser du om dagen?'] = $plan->customer->getCustomerAttribute('user_data.foods.bread');
                    $email_array[$i]['Kommer du smør eller margarine på brødet eller bruger du det i din daglige madlavning?'] = $plan->customer->getCustomerAttribute('user_data.foods.butter');
                    $email_array[$i]['Hvor mange kartofler, ris, pasta eller lignede spiser du om dagen?'] = $plan->customer->getCustomerAttribute('user_data.foods.wheat');
                    $email_array[$i]['Hvor ofte spiser du kød og kødprodukter?'] = $plan->customer->getCustomerAttribute('user_data.foods.meat');
                    $email_array[$i]['Hvor ofte spiser du fed fisk om ugen?'] = $plan->customer->getCustomerAttribute('user_data.foods.fish');
                    $email_array[$i]['Hvor mange mejeriprodukter får du dagligt?'] = $plan->customer->getCustomerAttribute('user_data.foods.dairy');
                } catch (\Exception $exception) {
                    \Log::error("Foods " . $exception->getFile() . " on line " . $exception->getLine());
                }
                $i++;
            } catch (\Exception $exception) {
                \Log::error($exception->getFile() . " on line " . $exception->getLine());
            }
        }
        $stat_count = Setting::where('identifier', '=', 'stat_' . $lang)->first();
        $stat_count->value = 0;
        $stat_count->save();
        $newArray = array_chunk($email_array, 1000);

        \Log::info('New array ' . count($newArray));

        try {
            foreach ($newArray as $key=>$arr) {
                \Excel::create('all_users_' . $lang . "_".$key, function ($excel) use ($arr) {
                    $excel->sheet('All users', function ($sheet) use ($arr) {
                        $sheet->fromArray($arr, null, 'A1', true);
                    });
                })->store('xls', storage_path('excel/exports/' . $lang));
            }

            $files = glob(storage_path('excel/exports/' . $lang . '/*'));
            \Zipper::make(storage_path('excel/exports/all_users_' . $lang . '.zip'))->add($files)->close();
            \File::deleteDirectory(storage_path('excel/exports/' . $lang));
            \Log::info('Succes create CSV ' . $lang);

        } catch (\Exception $exception) {
            \Log::error($exception->getFile() . " on line " . $exception->getLine());
        }
    }
}