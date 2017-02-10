<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 09.02.17
 * Time: 16:00
 */

namespace app\Http\Controllers\Dashboard;

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
                    return Plan::whereNotNull('subscription_snoozed_until')->whereBetween('created_at', [$data['start-date'], $data['end-date']])->count();
                case 3:
                    return Customer::where('order_count', '>', 1)->whereBetween('created_at', [$data['start-date'], $data['end-date']])->count();
                case 4:
                    return Plan::whereNotNull('subscription_cancelled_at')->whereBetween('created_at', [$data['start-date'], $data['end-date']])->count();
                default:
                    return 0;
            }
        } else {
            return \Redirect::back()->withErrors("Access denied!");
        }
    }

}