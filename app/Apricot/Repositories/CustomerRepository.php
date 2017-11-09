<?php namespace App\Apricot\Repositories;


use App\Customer;
use App\Plan;
use Date;

class CustomerRepository
{
	public function all()
	{
		return Customer::orderBy('created_at', 'DESC')->get();
	}

	public function allLocale($locale)
	{
		return Customer::where('locale','like', $locale)->orderBy('created_at', 'DESC')->get();
	}

    public function allLocaleTime($locale, $start_date, $end_date)
    {
        return Customer::where('locale','like', $locale)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at', 'DESC')->get();
    }

	public function allActive()
	{
		return Plan::whereNull('subscription_cancelled_at')->whereNotNull('subscription_rebill_at')->count();
	}


	public function allActiveLocale($locale)
	{
		return Plan::where('currency','like', $locale)->whereNull('subscription_cancelled_at')->whereNotNull('subscription_rebill_at')->whereNull('deleted_at')->count();
	}

    public function allActiveLocaleTime($locale, $start, $end)
    {
        return Plan::whereDate('created_at', '<', $end)->where('currency','like', $locale)
            ->where( function ( $query ) use ( $end )
            {
                $query->whereNull( 'subscription_cancelled_at' )
                    ->orWhereDate( 'subscription_cancelled_at', '>', $end );
            } )
            ->whereNotNull('subscription_rebill_at')
            ->whereNull('deleted_at');
    }


    public function allNewLocaleTime($locale, $start, $end)
    {
        return Plan::whereBetween('created_at', [$start, $end])->where('currency','like', $locale);
    }

    public function allActivePickLocale($locale)
    {
        return Plan::where('currency','like', $locale)->where('is_custom','=', 1)->whereNull('subscription_cancelled_at')->whereNotNull('subscription_rebill_at')->count();
    }


	public function churnDay()
	{
		return Plan::whereNotNull('subscription_cancelled_at')->whereBetween( 'subscription_cancelled_at', [ Date::today()->setTime( 0, 0, 0 ), Date::today()->setTime( 23, 59, 59 ) ] )->count();
	}


    public function churnPickDay()
    {
        return Plan::whereNotNull('subscription_cancelled_at')->where('is_custom','=', 1)->whereBetween( 'subscription_cancelled_at', [ Date::today()->setTime( 0, 0, 0 ), Date::today()->setTime( 23, 59, 59 ) ] )->count();


    }

	public function rebillAble()
	{
		return Customer::rebillable();
	}

	public function getToday()
	{
		return Customer::today();
	}



    public function getPickToday()
    {
        $customers = Customer::today()->get();

        $count = 0;

        if(count($customers) > 0){
            foreach ($customers as $customer) {
                if($customer->getPlan()->is_custom == 1){
                    $count++;
                }
            }
        }

        return $count;
    }
	public function getAmbassador(){

		return Customer::where('ambas','=', 1)->where('goal','!=',0)->where('coupon','!=','')->orderBy('created_at', 'DESC')->get();
	}

	public function getNewCustomer(){
		$date = new \DateTime();
		$date->modify('-21 days');
		return Plan::whereNull('subscription_cancelled_at')->whereNotNull('subscription_rebill_at')
			->where('subscription_started_at','like','%'.$date->format('Y-m-d').'%')
			->get();
	}

	public function getMonthlyNew()
	{
		return Customer::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month, COUNT(DISTINCT id) as total")
					->groupBy(\DB::raw("YEAR(created_at), MONTH(created_at)"))
					->get();
	}

    public static function getMonthlyFinish($year, $month)
    {

        return Plan::whereNotNull('subscription_rebill_at')

            ->where( function ( $query ) use ( $year )
            {
                $query->whereNull('subscription_cancelled_at')
                    ->orWhereDate( 'subscription_cancelled_at', '>', $year );
            } )


            ->whereDate('created_at', '<', $year)
            ->count();
    }



    public function getDailyNew()
	{
		return Customer::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, COUNT(DISTINCT id) as total")
			->groupBy(\DB::raw("YEAR(created_at), MONTH(created_at), DAY(created_at)"))
			->get();
	}


	public function getDailyUnsub()
	{
		return Plan::selectRaw("YEAR(subscription_cancelled_at) as year, MONTH(subscription_cancelled_at) as month, DAY(subscription_cancelled_at) as day, COUNT(DISTINCT id) as total")
			->whereNotNull('subscription_cancelled_at')
			->groupBy(\DB::raw("YEAR(subscription_cancelled_at), MONTH(subscription_cancelled_at), DAY(subscription_cancelled_at)"))
			->get();
	}




	public function getAlmostCustomer()
	{
		return \DB::select('select * from almost_customers where email not in (select users.email from users inner join almost_customers on almost_customers.email=users.email)');
	}

	public function getAlmostCustomerNotSend()
	{
		return \DB::select('select * from almost_customers where email not in (select users.email from users inner join almost_customers on almost_customers.email=users.email) and sent = 0');
	}
}