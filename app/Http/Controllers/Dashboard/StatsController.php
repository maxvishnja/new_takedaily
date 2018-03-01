<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Helpers\CreateCsvAllCustomers;
use App\Apricot\Repositories\CustomerRepository;
use App\Coupon;
use App\Customer;
use App\Events\CreateAllCsv;
use App\Events\CreateCsv;
use App\Http\Controllers\Controller;
use App\Order;
use App\Plan;
use App\Setting;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;

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
        $active_coupon = Coupon::orderBy('code', 'ASC')->where('valid_to', '>=', date('Y-m-d'))->where('description', '!=', 'Upsell discount')->get();
        $inactive_coupon = Coupon::orderBy('code', 'ASC')->where('valid_to', '<', date('Y-m-d'))->where('description', '!=', 'Upsell discount')->get();
        return view('admin.stats.home', [
            'active_user' => $active_user,
            'active_coupon' => $active_coupon,
            'inactive_coupon' => $inactive_coupon,
        ]);
    }


    function getCohortsIndex()
    {
        return view('admin.stats.cohorts.home');
    }


    function getCohortsAgeCsv(Request $request)
    {

        $data = $request->all();


        if ($data) {

            $users_array = [];


            switch ($data['lang']) {

                case '0':

                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array[$month . ' 2017']['Month'] = $month . ' 2017';
                        $users_array[$month . ' 2017']['Signups'] = Plan::getSignupsAge(sprintf('%02d', $key), 2017, $data['age']);
                        $users_array[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                $cohorts = Plan::getCohortsAge(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['age']);
                                $users_array[$month . ' 2017'][$y] = $cohorts->customers . "(" . $cohorts->cohorts . "%)";
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        $users_array[$month2 . ' 2018']['Signups'] = Plan::getSignupsAge(sprintf('%02d', $key2), 2018, $data['age']);
                        $users_array[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                $cohorts2 = Plan::getCohortsAge(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['age']);
                                $users_array[$month2 . ' 2018'][$y2] = $cohorts2->customers . "(" . $cohorts2->cohorts . "%)";
                            }
                        }

                    }

                    $users_array2 = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array2[$month . ' 2017']['Month'] = $month . ' 2017';
                        $users_array2[$month . ' 2017']['Revenues'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsAgeRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017, $data['age']), 2);
                        $users_array2[$month . ' 2017']['0'] = '100%';
                       foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                $users_array2[$month . ' 2017'][$y] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsAgeRevenue(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['age']), 2);
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array2[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        $users_array2[$month2 . ' 2018']['Revenues'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsAgeRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018, $data['age']), 2);
                        $users_array2[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                               $users_array2[$month2 . ' 2018'][$y2] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsAgeRevenue(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['age']), 2);
                            }
                        }
                    }


                    $users_array3 = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array3[$month . ' 2017']['Month'] = $month . ' 2017';
                        if (Plan::getSignupsAge(sprintf('%02d', $key), 2017, $data['age']) != 0) {
                            $cus = Plan::getSignupsAge(sprintf('%02d', $key), 2017, $data['age']);
                            $users_array3[$month . ' 2017']['ARPU'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsAgeRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017, $data['age']) / $cus, 2) . " (" . $cus . ")";
                        } else {
                            $users_array3[$month . ' 2017']['ARPU'] = 0;
                        }
                        $users_array3[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                if (Plan::getCohortsAge(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['age'])->customers != 0) {
                                    $users_array3[$month . ' 2017'][$y] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsAgeArpu(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['age'])->rev, 2) . " (" . Plan::getCohortsAgeArpu(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['age'])->count . ")";
                                } else {
                                    $users_array3[$month . ' 2017'][$y] = 0;
                                }
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array3[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        if (Plan::getSignupsAge(sprintf('%02d', $key2), 2018, $data['age']) != 0) {
                            $cus2 = Plan::getSignupsAge(sprintf('%02d', $key2), 2018, $data['age']);
                            $users_array3[$month2 . ' 2018']['ARPU'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsAgeRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018, $data['age']) / $cus2, 2) . " (" . $cus2 . ")";
                        } else {
                            $users_array3[$month2 . ' 2018']['ARPU'] = 0;
                        }
                        $users_array3[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                if (Plan::getCohortsAge(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['age'])->customers != 0) {
                                    $users_array3[$month2 . ' 2018'][$y2] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsAgeArpu(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['age'])->rev, 2) . " (" . Plan::getCohortsAgeArpu(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['age'])->count . ")";
                                } else {
                                    $users_array3[$month2 . ' 2018'][$y2] = 0;
                                }
                            }
                        }
                    }



                    \Excel::create('cohorts_month', function ($excel) use ($users_array, $users_array2, $users_array3) {

                        $excel->sheet('All users', function ($sheet) use ($users_array) {
                            $sheet->fromArray($users_array, null, 'A1', true);
                        });
                        $excel->sheet('Revenues', function ($sheet) use ($users_array2) {
                            $sheet->fromArray($users_array2, null, 'A1', true);
                        });
                        $excel->sheet('ARPU', function ($sheet) use ($users_array3) {
                            $sheet->fromArray($users_array3, null, 'A1', true);
                        });

                    })->download('xls');

                    return \Redirect::back();


                default:

                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array[$month . ' 2017']['Month'] = $month . ' 2017';
                        $users_array[$month . ' 2017']['Signups'] = Plan::getSignupsAgeCountry(sprintf('%02d', $key), 2017, $data['lang'], $data['age']);
                        $users_array[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                $cohorts = Plan::getCohortsAgeCountry(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['lang'], $data['age']);
                                $users_array[$month . ' 2017'][$y] = $cohorts->customers . "(" . $cohorts->cohorts . "%)";
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        $users_array[$month2 . ' 2018']['Signups'] = Plan::getSignupsAgeCountry(sprintf('%02d', $key2), 2018, $data['lang'], $data['age']);
                        $users_array[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                $cohorts2 = Plan::getCohortsAgeCountry(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['lang'], $data['age']);
                                $users_array[$month2 . ' 2018'][$y2] = $cohorts2->customers . "(" . $cohorts2->cohorts . "%)";
                            }
                        }

                    }

                    $users_array2 = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array2[$month . ' 2017']['Month'] = $month . ' 2017';
                        $users_array2[$month . ' 2017']['Revenues'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsAgeCountryRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017, $data['age'], $data['lang']), 2);
                        $users_array2[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                $users_array2[$month . ' 2017'][$y] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsAgeCountryRevenue(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['age'], $data['lang']), 2);
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array2[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        $users_array2[$month2 . ' 2018']['Revenues'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsAgeCountryRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018, $data['age'], $data['lang']), 2);
                        $users_array2[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                $users_array2[$month2 . ' 2018'][$y2] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsAgeCountryRevenue(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['age'], $data['lang']), 2);
                            }
                        }
                    }



                    $users_array3 = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array3[$month . ' 2017']['Month'] = $month . ' 2017';
                        if (Plan::getSignupsAgeCountry(sprintf('%02d', $key), 2017, $data['lang'], $data['age']) != 0) {
                            $cus = Plan::getSignupsAgeCountry(sprintf('%02d', $key), 2017, $data['lang'], $data['age']);
                            $users_array3[$month . ' 2017']['ARPU'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsAgeCountryRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017, $data['age'], $data['lang']) / $cus, 2) . " (" . $cus . ")";
                        } else {
                            $users_array3[$month . ' 2017']['ARPU'] = 0;
                        }
                        $users_array3[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                if (Plan::getCohortsAgeCountry(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['lang'], $data['age'])->customers != 0) {
                                    $users_array3[$month . ' 2017'][$y] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsAgeCountryArpu(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['age'], $data['lang'])->rev, 2) . " (" . Plan::getCohortsAgeCountryArpu(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['age'], $data['lang'])->count . ")";
                                } else {
                                    $users_array3[$month . ' 2017'][$y] = 0;
                                }
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array3[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        if (Plan::getSignupsAgeCountry(sprintf('%02d', $key2), 2018, $data['lang'], $data['age']) != 0) {
                            $cus2 = Plan::getSignupsAgeCountry(sprintf('%02d', $key2), 2018, $data['lang'],$data['age']);
                            $users_array3[$month2 . ' 2018']['ARPU'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsAgeCountryRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018, $data['age'], $data['lang']) / $cus2, 2) . " (" . $cus2 . ")";
                        } else {
                            $users_array3[$month2 . ' 2018']['ARPU'] = 0;
                        }
                        $users_array3[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                if (Plan::getCohortsAgeCountry(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['lang'],$data['age'])->customers != 0) {
                                    $users_array3[$month2 . ' 2018'][$y2] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsAgeCountryArpu(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['age'], $data['lang'])->rev, 2) . " (" . Plan::getCohortsAgeCountryArpu(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['age'], $data['lang'])->count . ")";
                                } else {
                                    $users_array3[$month2 . ' 2018'][$y2] = 0;
                                }
                            }
                        }
                    }




                    \Excel::create('cohorts_month', function ($excel) use ($users_array, $users_array2, $users_array3) {

                        $excel->sheet('All users', function ($sheet) use ($users_array) {
                            $sheet->fromArray($users_array, null, 'A1', true);
                        });
                        $excel->sheet('Revenues', function ($sheet) use ($users_array2) {
                            $sheet->fromArray($users_array2, null, 'A1', true);
                        });
                        $excel->sheet('ARPU', function ($sheet) use ($users_array3) {
                            $sheet->fromArray($users_array3, null, 'A1', true);
                        });


                    })->download('xls');
                    return \Redirect::back();
            }



        }


        return \Redirect::back()->withErrors("No data!");


    }

    /**
     * @param Request $request
     * @return int
     */
    function getData(Request $request)
    {
        if (\Request::ajax()) {
            $data = $request->all();
            if ($data['lang'] == 'nl') {
                $currency = "EUR";
            } else {
                $currency = "DKK";
            }
            $data['start_date'] = $data['start_date'] . " 00:01:00";
            $data['end_date'] = $data['end_date'] . " 23:59:00";
            switch ($data['csv-category']) {
                case 1:
                    return $this->repo->allActiveLocaleTime($currency, $data['start_date'], $data['end_date'])->count();
                case 2:
                    return Plan::where('currency', 'like', $currency)->whereNotNull('subscription_snoozed_until')->whereBetween('subscription_snoozed_until', [$data['start_date'], $data['end_date']])->count();
                case 3:
                    $ordercount = Plan::whereBetween('updated_at', [$data['start_date'], $data['end_date']])->whereNull('subscription_snoozed_until')->whereNull('subscription_cancelled_at')->get();
                    $i = 0;
                    foreach ($ordercount as $order) {
                        $newdate = \Date::createFromFormat('Y-m-d H:i:s', $order->subscription_started_at)->addDays(28)->addWeekdays(5);
                        if ($newdate < \Date::createFromFormat('Y-m-d H:i:s', $order->subscription_rebill_at)) {
                            $i++;
                        }
                    }
                    return $i;
                case 4:
                    return Plan::whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->count();
                case 5:
                    return Order::whereNotNull('repeat')->whereBetween('created_at', [$data['start-date'], $data['end-date']])->count();
                case 6:
                    return $this->repo->allNewLocaleTime($currency, $data['start_date'], $data['end_date'])->count();
                case 7:
                    $orders = Order::selectRaw("COUNT(*) AS count, customer_id")
                        ->whereNull('repeat')
                        ->where('total', '=', 0)
                        ->where('state', '=', 'sent')
                        ->where('currency', '=', $currency)
                        ->groupBy('customer_id')
                        ->having('count', '>', 1)
                        ->get();
                    return count($orders);


                case 8:
                    return Plan::where('currency', 'like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->where('unsubscribe_reason', 'like', '%14 days expired%')->count();

                case 9:
                    return Plan::where('currency', 'like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->where('attempt', '>', 0)->where('attempt', '<', 14)->count();

                default:
                    return 0;
            }
        } else {
            return \Redirect::back()->withErrors("Access denied!");
        }
    }

    public function getStatsCustomersFromCoupon(Request $request)
    {
        $data = $request->all();
        $customers_coupon_count = Order::where('coupon', '!=', '')
            ->count();
        $customers_coupon_count_name = Order::where('coupon', '==', 'KIRSTENTEST1')
            ->count();
        return \Response::json([
            'message' => $data,
            'count' => $customers_coupon_count,
            'count coupon from name' => $customers_coupon_count_name
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function exportCsv(Request $request)
    {
        $data = $request->all();
        //$customers = $this->repo->allLocaleTime($data['lang']);
        $customers = $this->repo->allLocaleTime($data['lang'], $data['start_date_all_customers'], $data['end_date_all_customers']);
        $stat_count = Setting::where('identifier', '=', 'month_stat_' . $data['lang'])->first();
        $stat_count->value = 1;
        $stat_count->save();
        \Log::info('Click on create month CSV' . $data['lang']);
        \Event::fire(new CreateCsv($customers, $data['lang'], $data['start_date_all_customers'], $data['end_date_all_customers']));
        return \Response::json([
            'message' => 'Csv start create'
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function exportCsvAllCustomers(Request $request)
    {
        $data = $request->all();
        $customers = $this->repo->allLocale($data['lang']);
        $stat_count = Setting::where('identifier', '=', 'stat_' . $data['lang'])->first();
        $stat_count->value = 1;
        $stat_count->save();

        \Log::info('Click on create All CSV' . $data['lang']);
        \Event::fire(new CreateAllCsv($customers, $data['lang']));
        return \Response::json([
            'message' => 'Csv start create for all customers ' . $data['lang']
        ], 200);
    }

    function downloadCsv(Request $request)
    {
        $data = $request->all();
        $filename = storage_path('excel/exports/all_active_mails_months_' . $data['lang'] . '.xls');
        if (file_exists($filename)) {
            $stat_count = Setting::where('identifier', '=', 'month_stat_' . $data['lang'])->first();
            $stat_count->value = 0;
            $stat_count->save();
            return \Response::download($filename)->deleteFileAfterSend(true);
        } else {
            return \Redirect::back()->withErrors("No file! Please create it");
        }
    }

    function downloadCsvAllCustomers(Request $request)
    {
        $data = $request->all();
        $filename = storage_path('excel/exports/all_active_mails_' . $data['lang'] . '.xls');
        if (file_exists($filename)) {
            $stat_count = Setting::where('identifier', '=', 'stat_' . $data['lang'])->first();
            $stat_count->value = 0;
            $stat_count->save();
            return \Response::download($filename)->deleteFileAfterSend(true);
        } else {
            return \Redirect::back()->withErrors("No file! Please create it");
        }
    }

    function checkCsv(Request $request)
    {
        $data = $request->all();
        $filename = storage_path('excel/exports/all_active_mails_months_' . $data['lang'] . '.xls');
        if (file_exists($filename)) {
            return \Response::json([
                'message' => 'Success'
            ], 200);
        } else {
            return \Response::json([
                'message' => 'Error'
            ], 400);
        }
    }

    function checkCsvAllCustomers(Request $request)
    {
        $data = $request->all();
        $filename = storage_path('excel/exports/all_active_mails_' . $data['lang'] . '.xls');
        if (file_exists($filename)) {
            return \Response::json([
                'message' => 'Success'
            ], 200);
        } else {
            return \Response::json([
                'message' => 'Error'
            ], 400);
        }
    }

    function cohortsToCsv(Request $request)
    {
        $data = $request->all();
        if ($data) {
            switch ($data['rate']) {
                case 4:
                    $users_array = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array[$month . ' 2017']['Month'] = $month . ' 2017';
                        $users_array[$month . ' 2017']['Signups'] = Plan::getSignups(sprintf('%02d', $key), 2017);
                        $users_array[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                $users_array[$month . ' 2017'][$y] = Plan::getCohorts(sprintf('%02d', $key), sprintf('%02d', $y), 2017)->customers . "(" . Plan::getCohorts(sprintf('%02d', $key), sprintf('%02d', $y), 2017)->cohorts . "%)";
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        $users_array[$month2 . ' 2018']['Signups'] = Plan::getSignups(sprintf('%02d', $key2), 2018);
                        $users_array[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                $users_array[$month2 . ' 2018'][$y2] = Plan::getCohorts(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018)->customers . "(" . Plan::getCohorts(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018)->cohorts . "%)";
                            }
                        }
                    }
                    $users_array2 = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array2[$month . ' 2017']['Month'] = $month . ' 2017';
                        $users_array2[$month . ' 2017']['Revenues'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017), 2);
                        $users_array2[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                $users_array2[$month . ' 2017'][$y] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsRevenue(sprintf('%02d', $key), sprintf('%02d', $y), 2017), 2);
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array2[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        $users_array2[$month2 . ' 2018']['Revenues'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018), 2);
                        $users_array2[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                $users_array2[$month2 . ' 2018'][$y2] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsRevenue(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018), 2);
                            }
                        }
                    }
                    $users_array3 = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array3[$month . ' 2017']['Month'] = $month . ' 2017';
                        if (Plan::getSignups(sprintf('%02d', $key), 2017) != 0) {
                            $users_array3[$month . ' 2017']['ARPU'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017) / Plan::getSignups(sprintf('%02d', $key), 2017), 2) . " (" . Plan::getSignups(sprintf('%02d', $key), 2017) . ")";
                        } else {
                            $users_array3[$month . ' 2017']['ARPU'] = 0;
                        }
                        $users_array3[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                if (Plan::getCohorts(sprintf('%02d', $key), sprintf('%02d', $y), 2017)->customers != 0) {
                                    $users_array3[$month . ' 2017'][$y] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsArpu(sprintf('%02d', $key), sprintf('%02d', $y), 2017)->rev, 2) . " (" . Plan::getCohortsArpu(sprintf('%02d', $key), sprintf('%02d', $y), 2017)->count . ")";
                                } else {
                                    $users_array3[$month . ' 2017'][$y] = 0;
                                }
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array3[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        if (Plan::getSignups(sprintf('%02d', $key2), 2018) != 0) {
                            $users_array3[$month2 . ' 2018']['ARPU'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018) / Plan::getSignups(sprintf('%02d', $key2), 2018), 2) . " (" . Plan::getSignups(sprintf('%02d', $key2), 2018) . ")";
                        } else {
                            $users_array3[$month2 . ' 2018']['ARPU'] = 0;
                        }
                        $users_array3[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                if (Plan::getCohorts(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018)->customers != 0) {
                                    $users_array3[$month2 . ' 2018'][$y2] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsArpu(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018)->rev, 2) . " (" . Plan::getCohortsArpu(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018)->count . ")";
                                } else {
                                    $users_array3[$month2 . ' 2018'][$y2] = 0;
                                }
                            }
                        }
                    }
                    \Excel::create('cohorts_month', function ($excel) use ($users_array, $users_array2, $users_array3) {
                        $excel->sheet('All users', function ($sheet) use ($users_array) {
                            $sheet->fromArray($users_array, null, 'A1', true);
                        });
                        $excel->sheet('Revenue', function ($sheet) use ($users_array2) {
                            $sheet->fromArray($users_array2, null, 'A1', true);
                        });
                        $excel->sheet('ARPU', function ($sheet) use ($users_array3) {
                            $sheet->fromArray($users_array3, null, 'A1', true);
                        });
                    })->download('xls');
                    return \Redirect::back();
                case 5:
                    $users_array = [];
                    foreach (range(0, date('W') - 1) as $week) {
                        $users_array[$week]['Week'] = $week + 1;
                        $users_array[$week]['Signups'] = Plan::getSignupsWeek(sprintf('%02d', $week));
                        $users_array[$week]['0'] = '100%';
                        foreach (range(01, date('W')) as $y) {
                            if (date('W') - $week >= $y) {
                                $users_array[$week][$y] = Plan::getCohortsWeek(sprintf('%02d', $week), sprintf('%02d', $y));
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
                    $users_array = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array[$month . ' 2017']['Month'] = $month . ' 2017';
                        $users_array[$month . ' 2017']['Signups'] = Plan::getSignupsCountry(sprintf('%02d', $key), 2017, $data['rate']);
                        $users_array[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                $users_array[$month . ' 2017'][$y] = Plan::getCohortsCountry(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['rate'])->customers . "(" . Plan::getCohortsCountry(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['rate'])->cohorts . "%)";
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        $users_array[$month2 . ' 2018']['Signups'] = Plan::getSignupsCountry(sprintf('%02d', $key2), 2018, $data['rate']);
                        $users_array[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                $users_array[$month2 . ' 2018'][$y2] = Plan::getCohortsCountry(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['rate'])->customers . "(" . Plan::getCohortsCountry(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['rate'])->cohorts . "%)";
                            }
                        }
                    }
                    $users_array2 = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array2[$month . ' 2017']['Month'] = $month . ' 2017';
                        $users_array2[$month . ' 2017']['Revenues'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsCountryRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017, $data['rate']), 2);
                        $users_array2[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                $users_array2[$month . ' 2017'][$y] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsCountryRevenue(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['rate']), 2);
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array2[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        $users_array2[$month2 . ' 2018']['Revenues'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsCountryRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018, $data['rate']), 2);
                        $users_array2[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                $users_array2[$month2 . ' 2018'][$y2] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsCountryRevenue(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['rate']), 2);
                            }
                        }
                    }
                    $users_array3 = [];
                    foreach (trans('flow.datepicker.months_long') as $key => $month) {
                        $users_array3[$month . ' 2017']['Month'] = $month . ' 2017';
                        if (Plan::getSignupsCountry(sprintf('%02d', $key), 2017, $data['rate']) != 0) {
                            $users_array3[$month . ' 2017']['ARPU'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsCountryRevenue(sprintf('%02d', $key), sprintf('%02d', $key), 2017, $data['rate']) / Plan::getSignupsCountry(sprintf('%02d', $key), 2017, $data['rate']), 2) . " (" . Plan::getSignupsCountry(sprintf('%02d', $key), 2017, $data['rate']) . ")";
                        } else {
                            $users_array3[$month . ' 2017']['ARPU'] = 0;
                        }
                        $users_array3[$month . ' 2017']['0'] = '100%';
                        foreach (range($key, \Date::now()->diffInMonths(\Date::createFromFormat('Y-m-d', '2016-12-01'))) as $y) {
                            if ($y >= $key) {
                                if (Plan::getCohortsCountry(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['rate'])->customers != 0) {
                                    $users_array3[$month . ' 2017'][$y] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsCountryArpu(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['rate'])->rev, 2) . " (" . Plan::getCohortsCountryArpu(sprintf('%02d', $key), sprintf('%02d', $y), 2017, $data['rate'])->count . ")";
                                } else {
                                    $users_array3[$month . ' 2017'][$y] = 0;
                                }
                            }
                        }
                    }
                    foreach (trans('flow.datepicker.months_long') as $key2 => $month2) {
                        $users_array3[$month2 . ' 2018']['Month'] = $month2 . ' 2018';
                        if (Plan::getSignupsCountry(sprintf('%02d', $key2), 2018, $data['rate']) != 0) {
                            $users_array3[$month2 . ' 2018']['ARPU'] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getSignupsCountryRevenue(sprintf('%02d', $key2), sprintf('%02d', $key2), 2018, $data['rate']) / Plan::getSignupsCountry(sprintf('%02d', $key2), 2018, $data['rate']), 2) . " (" . Plan::getSignupsCountry(sprintf('%02d', $key2), 2018, $data['rate']) . ")";
                        } else {
                            $users_array3[$month2 . ' 2018']['ARPU'] = 0;
                        }
                        $users_array3[$month2 . ' 2018']['0'] = '100%';
                        foreach (range($key2, 12) as $y2) {
                            if ($y2 >= $key2 and $y2 <= (int)date('m')) {
                                if (Plan::getCohortsCountry(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['rate'])->customers != 0) {
                                    $users_array3[$month2 . ' 2018'][$y2] = \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(Plan::getCohortsCountryArpu(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['rate'])->rev, 2) . " (" . Plan::getCohortsCountryArpu(sprintf('%02d', $key2), sprintf('%02d', $y2), 2018, $data['rate'])->count . ")";
                                } else {
                                    $users_array3[$month2 . ' 2018'][$y2] = 0;
                                }
                            }
                        }
                    }
                    \Excel::create('cohorts_month_country_' . $data['rate'], function ($excel) use ($users_array, $users_array2, $users_array3) {
                        $excel->sheet('All users', function ($sheet) use ($users_array) {
                            $sheet->fromArray($users_array, null, 'A1', true);
                        });
                        $excel->sheet('Revenue', function ($sheet) use ($users_array2) {
                            $sheet->fromArray($users_array2, null, 'A1', true);
                        });
                        $excel->sheet('ARPU', function ($sheet) use ($users_array3) {
                            $sheet->fromArray($users_array3, null, 'A1', true);
                        });
                    })->download('xls');
                    return \Redirect::back();
                //return \Redirect::back()->withErrors("No data!");
            }
        }
    }

    public function getWrongSb(Request $request)
    {
        $data = $request->all();
        if ($data) {
            $repo = new CustomerRepository();
            $customers = $repo->rebillAble();
            $email_array = [];
            $i = 0;
            foreach ($customers->get() as $customer) {
                $lastOrder = $customer->orders()->latest()->first();
                if (Date::createFromFormat('Y-m-d H:i:s', $customer->plan->subscription_rebill_at)->diffInDays($lastOrder->updated_at) != 28) {
                    $email_array[$i]['Name'] = $customer->getName();
                    $email_array[$i]['Email Address'] = $customer->getEmail();
                    $email_array[$i]['Rebill'] = \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->subscription_rebill_at)->format('d/m/Y');
                    $email_array[$i]['Last order'] = \Date::createFromFormat('Y-m-d H:i:s', $lastOrder->updated_at)->format('d/m/Y');
                    $email_array[$i]['Difference'] = Date::createFromFormat('Y-m-d H:i:s', $customer->plan->subscription_rebill_at)->diffInDays($lastOrder->updated_at);
                    $email_array[$i]['Status order'] = $lastOrder->state;
                    $i++;
                }
            }
            if (empty($email_array)) {
                return \Redirect::back()->withErrors("No data!");
            }
            \Excel::create('wrong_users', function ($excel) use ($email_array) {
                $excel->sheet('All wrong users', function ($sheet) use ($email_array) {
                    $sheet->fromArray($email_array, null, 'A1', true);
                });
            })->download('xls');
            return \Redirect::back();
        }
        return \Redirect::back()->withErrors("Error!");
    }

    function exportDateCoupon(Request $request)
    {
        $data = $request->all();
        if ($data) {
            if ($data['coupon'] == 1) {
                $orders = Order::where('repeat', '=', $data['coupon'])->get();
            } else {
                $orders = Order::where('coupon', '=', $data['coupon'])->get();
            }
            if (count($orders) > 0) {
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
            if ($data['lang'] == 'nl') {
                $currency = "EUR";
            } else {
                $currency = "DKK";
            }
            $data['start_date'] = $data['start_date'] . " 00:01:00";
            $data['end_date'] = $data['end_date'] . " 23:59:00";
            switch ($data['csv-category']) {
                case 1:
                    $i = 0;
                    $plans = $this->repo->allActiveLocaleTime($currency, $data['start_date'], $data['end_date'])->get();
                    foreach ($plans as $plan) {
                        if (!empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")) {
                            $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                            $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                            $email_array[$i]['Phone'] = $plan->customer->getPhone();
                            $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                            $i++;
                        }
                    }
                    if (isset($email_array)) {
                        \Excel::create('active_user_from_' . $data['start_date'] . "_to_" . $data['end_date'] . "_" . $data['lang'], function ($excel) use ($email_array) {
                            $excel->sheet('All users', function ($sheet) use ($email_array) {
                                $sheet->fromArray($email_array, null, 'A1', true);
                            });
                        })->download('xls');
                        return \Redirect::back();
                    }
                case 6:
                    $i = 0;
                    $plans = $this->repo->allNewLocaleTime($currency, $data['start_date'], $data['end_date'])->get();
                    foreach ($plans as $plan) {
                        $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                        $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                        $email_array[$i]['Phone'] = $plan->customer->getPhone();
                        $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                        $i++;
                    }
                    if (isset($email_array)) {
                        \Excel::create('new_user_from_' . $data['start_date'] . "_to_" . $data['end_date'] . "_" . $data['lang'], function ($excel) use ($email_array) {
                            $excel->sheet('All users', function ($sheet) use ($email_array) {
                                $sheet->fromArray($email_array, null, 'A1', true);
                            });
                        })->download('xls');
                        return \Redirect::back();
                    }
                case 2:
                    $i = 0;
                    if ($data['lang'] == 'nl') {
                        $currency = "EUR";
                    } else {
                        $currency = "DKK";
                    }
                    $plans = Plan::where('currency', 'like', $currency)->whereNotNull('subscription_cancelled_at')->whereNotNull('subscription_started_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->get();
                    foreach ($plans as $plan) {
                        if (!empty($plan->customer) and !empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")) {
                            $email_array[$i]['ID'] = $plan->customer->id;
                            $email_array[$i]['Name'] = $plan->customer->getName();
                            $email_array[$i]['Phone'] = $plan->customer->getPhone();
                            $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                            $email_array[$i]['Order count'] = $plan->customer->order_count;
                            $email_array[$i]['Age'] = $plan->customer->getAge();
                            if ($plan->customer->getGender() == 1) {
                                $gender = 'male';
                            } else {
                                $gender = 'female';
                            }
                            $email_array[$i]['Gender'] = $gender;
                            $email_array[$i]['Signup date'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_started_at)->format('j. M Y');
                            $email_array[$i]['Cancel date'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_cancelled_at)->format('j. M Y');
                            $email_array[$i]['Reason'] = $plan->unsubscribe_reason;
                            $email_array[$i]['Supplements'] = '';
                            if ($plan->getVitamiPlan()) {
                                foreach ($plan->getVitamiPlan() as $vitamin) {
                                    $email_array[$i]['Supplements'] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)) . ", ";
                                }
                            }
                            $i++;
                        }
                    }
                    if (isset($email_array)) {
                        \Excel::create('mails_from_' . $data['start_date'] . "_to_" . $data['end_date'] . "_" . $data['lang'], function ($excel) use ($email_array) {
                            $excel->sheet('Unsubscribed users', function ($sheet) use ($email_array) {
                                $sheet->fromArray($email_array, null, 'A1', true);
                            });
                        })->download('xls');
                        return \Redirect::back();
                    }
                case 3:
                    $i = 0;
                    if ($data['lang'] == 'nl') {
                        $currency = "EUR";
                        \App::setLocale('nl');
                    } else {
                        $currency = "DKK";
                        \App::setLocale('da');
                    }
                    $plans = Plan::where('currency', 'like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->get();
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
                            $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                            $email_array[$i]['Phone'] = $plan->customer->getPhone();
                            $email_array[$i]['Cancel date'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_cancelled_at)->format('j. M Y');
                            $email_array[$i]['Age'] = $plan->customer->getAge();
                            $email_array[$i]['Supplements'] = '';
                            if ($plan->getVitamiPlan()) {
                                foreach ($plan->getVitamiPlan() as $vitamin) {
                                    $email_array[$i]['Supplements'] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)) . ", ";
                                }
                            }
                            $email_array[$i]['Last coupon'] = $plan->getLastCoupon();
                            $email_array[$i]['Reason'] = $plan->unsubscribe_reason;
                            $i++;
                        }
                    }
                    if (isset($email_array)) {
                        \Excel::create('reason_from_' . $data['start_date'] . "_to_" . $data['end_date'] . "_" . $data['lang'], function ($excel) use ($email_array) {
                            $excel->sheet('Unsubscribed users', function ($sheet) use ($email_array) {
                                $sheet->fromArray($email_array, null, 'A1', true);
                            });
                        })->download('xls');
                        return \Redirect::back();
                    }
                case 5:
                    $i = 0;
                    if ($data['lang'] == 'nl') {
                        $currency = "EUR";
                        \App::setLocale('nl');
                    } else {
                        $currency = "DKK";
                        \App::setLocale('da');
                    }
                    $plans = Plan::where('currency', 'like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->get();
                    foreach ($plans as $plan) {
                        if (!empty($plan->customer) and !empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")
                            and strstr($plan->unsubscribe_reason, 'from Dashboard')
                        ) {
                            $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                            $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                            $email_array[$i]['Phone'] = $plan->customer->getPhone();
                            if ($plan->snoozing_at) {
                                $email_array[$i]['Sent postponing mail'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->snoozing_at)->format('j. M Y');
                            } else {
                                $email_array[$i]['Sent postponing mail'] = 'No data';
                            }
                            $email_array[$i]['Cancel date'] = \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_cancelled_at)->format('j. M Y');
                            $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                            $email_array[$i]['Age'] = $plan->customer->getAge();
                            $email_array[$i]['Supplements'] = '';
                            if ($plan->getVitamiPlan()) {
                                foreach ($plan->getVitamiPlan() as $vitamin) {
                                    $email_array[$i]['Supplements'] .= \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)) . ", ";
                                }
                            }
                            $email_array[$i]['Last coupon'] = $plan->getLastCoupon();
                            $email_array[$i]['Reason'] = $plan->unsubscribe_reason;
                            $i++;
                        }
                    }
                    if (isset($email_array)) {
                        \Excel::create('mails_from_' . $data['start_date'] . "_to_" . $data['end_date'] . "_" . $data['lang'], function ($excel) use ($email_array) {
                            $excel->sheet('Unsubscribed from dashboard', function ($sheet) use ($email_array) {
                                $sheet->fromArray($email_array, null, 'A1', true);
                            });
                        })->download('xls');
                        return \Redirect::back();
                    }
                case 4:
                    $i = 0;
                    if ($data['lang'] == 'nl') {
                        $currency = "EUR";
                        \App::setLocale('nl');
                    } else {
                        $currency = "DKK";
                        \App::setLocale('da');
                    }
                    $newdate = \Date::now()->subWeeks($data['weeks']);
                    $plans = Plan::where('currency', 'like', $currency)->whereNull('subscription_cancelled_at')->where('subscription_started_at', '<',
                        \Date::createFromFormat('Y-m-d H:i:s', $newdate->addDay())->format('Y-m-d'))->get();
                    foreach ($plans as $plan) {
                        if (!empty($plan->customer) and !empty($plan->customer->getEmail()) and strstr($plan->customer->getEmail(), "@")
                        ) {
                            $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                            $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                            $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                            $email_array[$i]['Amount weeks'] = \Date::createFromFormat('Y-m-d H:i:s', $plan->subscription_started_at)->diffInWeeks();
                            $i++;
                        }
                    }
                    if (isset($email_array)) {
                        \Excel::create('mails_from_' . $data['start_date'] . "_to_" . $data['end_date'] . "_" . $data['lang'], function ($excel) use ($email_array) {
                            $excel->sheet('Amount of weeks', function ($sheet) use ($email_array) {
                                $sheet->fromArray($email_array, null, 'A1', true);
                            });
                        })->download('xls');
                        return \Redirect::back();
                    }
                case 7:
                    $orders = Order::selectRaw("COUNT(*) AS count, customer_id")
                        ->whereNull('repeat')
                        ->where('total', '=', 0)
                        ->where('state', '=', 'sent')
                        ->where('currency', '=', $currency)
                        ->groupBy('customer_id')
                        ->having('count', '>', 1)
                        ->get();
                    $i = 0;
                    foreach ($orders as $order) {
                        $email_array[$i]['First Name'] = $order->getCustomer()->getFirstName();
                        $email_array[$i]['Last Name'] = $order->getCustomer()->getLastName();
                        $email_array[$i]['Email Address'] = $order->getCustomer()->getEmail();
                        $email_array[$i]['Order count'] = $order->count;
                        if ($order->getCustomer()->getPlan()->subscription_canceled_at != null) {
                            $email_array[$i]['Status'] = "Not active";
                        } else {
                            $email_array[$i]['Status'] = "Active";
                        }
                        $i++;
                    }
                    if (isset($email_array)) {
                        \Excel::create("mails_free_from_" . $data['lang'], function ($excel) use ($email_array) {
                            $excel->sheet('Free subscription', function ($sheet) use ($email_array) {
                                $sheet->fromArray($email_array, null, 'A1', true);
                            });
                        })->download('xls');
                        return \Redirect::back();
                    }

                case 8:
                    $plans = Plan::where('currency', 'like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->where('unsubscribe_reason', 'like', '%14 days expired%')->get();
                    $i = 0;
                    foreach ($plans as $plan) {
                        $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                        $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                        $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                        $email_array[$i]['Unsubscribe date'] = $plan->subscription_cancelled_at;
                        $email_array[$i]['Attempt'] = $plan->attempt;

                        $i++;
                    }
                    if (isset($email_array)) {
                        \Excel::create("unsub_from_" . $data['lang'], function ($excel) use ($email_array) {
                            $excel->sheet('Unsub customer', function ($sheet) use ($email_array) {
                                $sheet->fromArray($email_array, null, 'A1', true);
                            });
                        })->download('xls');
                        return \Redirect::back();
                    }
                case 9:
                    $plans = Plan::where('currency', 'like', $currency)->whereNotNull('subscription_cancelled_at')->whereBetween('subscription_cancelled_at', [$data['start_date'], $data['end_date']])->where('attempt', '>', 0)->where('attempt', '<', 14)->get();

                    $i = 0;
                    foreach ($plans as $plan) {
                        $email_array[$i]['First Name'] = $plan->customer->getFirstName();
                        $email_array[$i]['Last Name'] = $plan->customer->getLastName();
                        $email_array[$i]['Email Address'] = $plan->customer->getEmail();
                        $email_array[$i]['Unsubscribe date'] = $plan->subscription_cancelled_at;
                        $email_array[$i]['Unsubscribe reason'] = $plan->unsubscribe_reason;
                        $email_array[$i]['Attempt'] = $plan->attempt;

                        $i++;
                    }
                    if (isset($email_array)) {
                        \Excel::create("unsub_from_" . $data['lang'], function ($excel) use ($email_array) {
                            $excel->sheet('Unsub customer no money', function ($sheet) use ($email_array) {
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

    public function getUnsubscribeReason(Request $request)
    {
        $data = $request->all();
        if ($data) {
            if ($data['lang'] == 'EUR') {
                \App::setLocale('nl');
            } else {
                \App::setLocale('da');
            }
            $count = 0;
            $reasons = array();
            $all = Plan::whereNotNull('subscription_cancelled_at')
                ->whereBetween('subscription_cancelled_at', [$data['start_dates'], $data['end_dates']])
                ->where('currency', '=', $data['lang'])
                ->count();
            for ($i = 0; $i < 6; $i++) {
                $count_res = Plan::whereNotNull('subscription_cancelled_at')
                    ->whereBetween('subscription_cancelled_at', [$data['start_dates'], $data['end_dates']])
                    ->where('unsubscribe_reason', 'like', trans('account.settings_cancel.reasons.' . $i . ''))
                    ->where('currency', 'like', $data['lang'])
                    ->count();
                $reasons[] = ["name" => trans('account.settings_cancel.reasons.' . $i . ''), "y" => $count_res];
                $count = $count + $count_res;
            }
            $reasons[6] = ["name" => 'Other reason', "y" => $all - $count];
            return $reasons;
        }
        return false;
    }

    public function getCohortsCountry(Request $request)
    {
        return view('admin.stats.cohorts.country', [
            'country' => $request->get('country'),
        ]);
    }
}