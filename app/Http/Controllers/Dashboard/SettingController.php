<?php

namespace App\Http\Controllers\Dashboard;


use App\Apricot\Repositories\SettingsRepository;
use App\Order;
use App\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    private $repo;

    /**
     * SettingController constructor.
     *
     * @param $repo
     */
    public function __construct(SettingsRepository $repo)
    {
        $this->repo = $repo;
    }

    function index()
    {

//	    $orders = Order::whereBetween('created_at', ['2017-12-13 00:00:00', '2018-01-03 23:59:00'])->where('state','sent')->get();
//        $i = 0;
//	    foreach ($orders as $order){
//
//	        if($order->customer->plan->subscription_canceled_at == null and $order->customer->plan->subscription_rebill_at != ''){
//	            if(count($orders)/2 > $i){
//	                $date = '2018-01-30 14:35:00';
//                } else{
//                    $date = '2018-01-31 14:35:00';
//                }
//                echo "Customer - ".$order->customer->getName()." - Old rebill - ". $order->customer->plan->subscription_rebill_at." - New date ".$date." <br/>";
//	            $order->customer->plan->subscription_rebill_at = $date;
//                $order->customer->plan->save();
//	            $i++;
//	        }
//
//        }
//
//        dd();

        return view('admin.settings.home', [
            'settings' => $this->repo->all()
        ]);
    }

    function update($id, Request $request)
    {
        $setting = Setting::find($id);

        if( ! $setting )
        {
            return \Redirect::back()->withErrors("Setting not found!");
        }

        $data = $request->all();

        $setting->update($data);

        return \Redirect::action('Dashboard\SettingController@index')->with('success', 'Settings blev opdateret!');
    }
}