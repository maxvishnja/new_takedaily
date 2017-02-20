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
                    $ordercount=Plan::whereBetween('updated_at', [$data['start-date'], $data['end-date']])->whereNull('subscription_snoozed_until')->whereNull('subscription_cancelled_at')->get();
                    $i = 0;
                    foreach($ordercount as $order){
                        $newdate = \Date::createFromFormat( 'Y-m-d H:i:s', $order->subscription_started_at )->addDays( 28 )->addWeekdays( 5 );

                       if($newdate < \Date::createFromFormat( 'Y-m-d H:i:s', $order->subscription_rebill_at )){
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

}