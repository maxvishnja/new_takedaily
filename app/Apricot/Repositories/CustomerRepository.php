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

	public function allActive()
	{
		return Plan::whereNull('subscription_cancelled_at')->whereNotNull('subscription_rebill_at')->count();
	}


	public function churnDay()
	{
		return Plan::whereNotNull('subscription_cancelled_at')->whereBetween( 'subscription_cancelled_at', [ Date::today()->setTime( 0, 0, 0 ), Date::today()->setTime( 23, 59, 59 ) ] )->count();
	}

	public function rebillAble()
	{
		return Customer::rebillable();
	}

	public function getToday()
	{
		return Customer::today();
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


	public function getDailyNew()
	{
		return Customer::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, COUNT(DISTINCT id) as total")
			->groupBy(\DB::raw("YEAR(created_at), MONTH(created_at), DAY(created_at)"))
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