<?php namespace App;
use App\Apricot\Libraries\PaymentDelegator;
use App\Apricot\Libraries\PaymentHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Mail\Message;
use Jenssegers\Date\Date;
use PhpParser\Node\Expr\Cast\Object_;
/**
 * Class Plan
 *
 * @package App
 * @property integer $id
 * @property string $payment_customer_token
 * @property string $payment_method
 * @property integer $price
 * @property integer $price_shipping
 * @property mixed $vitamins
 * @property string $subscription_started_at
 * @property string $subscription_cancelled_at
 * @property string $subscription_snoozed_until
 * @property string $subscription_rebill_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Customer $customer
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePaymentCustomerToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePaymentMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan wherePriceShipping($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereVitamins($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionStartedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionCancelledAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionSnoozedUntil($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereSubscriptionRebillAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plan rebillPending()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Plan notNotifiedPending()
 */
class Plan extends Model
{
    use SoftDeletes;
    /**
     * The database table for the model
     *
     * @var string
     */
    protected $table = 'plans';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_customer_token',
        'payment_method',
        'price',
        'price_discount',
        'count_discount',
        'price_shipping',
        'referal',
        'coupon_free',
        'last_coupon',
        'subscription_started_at',
        'subscription_cancelled_at',
        'subscription_snoozed_until',
        'subscription_rebill_at',
        'last_rebill_date',
        'old_rebill_at',
        'nutritionist_id',
        'unsubscribe_reason',
        'currency',
        'vitamins',
        'is_custom'
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer', 'id', 'plan_id');
    }
    public function isActive()
    {
        return !$this->isCancelled() && !is_null($this->getRebillAt());
    }
    public function isCancelled()
    {
        return !is_null($this->getSubscriptionCancelledAt());
    }
    public function hasFishoil()
    {
        $vitamins = json_decode($this->vitamins);
        if (is_null($vitamins)) {
            return false;
        }
        return Vitamin::whereIn('id', $vitamins)->where('code', '3e')->limit(1)->count() === 1; // todo unhardcode the 3e code
    }
    public function getVitamiPlan()
    {
        $vitamins = json_decode($this->vitamins);
        if (is_null($vitamins)) {
            return false;
        }
        foreach ($vitamins as $vitamin) {
            $allvitamins[] = Vitamin::find($vitamin);
        }
        if (isset($allvitamins)) {
            return $allvitamins;
        } else {
            return false;
        }
    }
    public static function getSignups($date, $year)
    {
        $customers = Plan::whereMonth('created_at', '=', $date)->whereYear('created_at', '=', $year)->count();


        return $customers;
    }

    public static function getSignupsAge($date, $year, $age)
    {

        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";

        $customers = Plan::select('plans.id')
            ->join('customers', 'customers.plan_id', '=', 'plans.id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $date)
            ->whereYear('plans.created_at', '=', $year)
            ->where('customer_attributes.identifier', '=', 'user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->count();


        return $customers;
    }


    public static function getSignupsAgeRevenue($signDate,$date, $year, $age)
    {
        $nextyear = $year;
        if($date > 12){
            $date = sprintf('%02d', $date - 12);
            $nextyear = 2018;
        }

        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";


        $ordersNl =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('customer_attributes.identifier', '=', 'user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->where('orders.currency', '=', 'EUR')
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $date)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');

        $ordersDk =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('customer_attributes.identifier', '=', 'user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->where('orders.currency', '=', 'DKK')
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $date)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');
        $sum = $ordersDk + (7.50 * $ordersNl);
        return $sum;
    }


    public static function getSignupsRevenue($signDate,$date, $year)
    {
        $nextyear = $year;
        if($date > 12){
            $date = sprintf('%02d', $date - 12);
            $nextyear = 2018;
        }
        $ordersNl =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('orders.currency', '=', 'EUR')
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $date)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');
        $ordersDk =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('orders.currency', '=', 'DKK')
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $date)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');
        $sum = $ordersDk + (7.50 * $ordersNl);
        return $sum;
    }



    public static function getSignupsCountry($date, $year, $lang)
    {
        $customers = Plan::whereMonth('created_at', '=', $date)->whereYear('created_at', '=', $year)->where('currency', $lang)->count();
        return $customers;
    }


    public static function getSignupsAgeCountry($date, $year, $lang, $age)
    {
        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";

        $customers = Plan::select('plans.id')
            ->join('customers', 'customers.plan_id', '=', 'plans.id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $date)
            ->whereYear('plans.created_at', '=', $year)
            ->where('plans.currency', '=', $lang)
            ->where('customer_attributes.identifier', '=', 'user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->count();

        return $customers;
    }


    public static function getSignupsCountryRevenue($signdate, $date, $year, $lang)
    {
        $nextyear = $year;
        if($date > 12){
            $date = sprintf('%02d', $date - 12);
            $nextyear = 2018;
        }
        $revenues =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->whereMonth('plans.created_at', '=', $signdate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('orders.currency', '=', $lang)
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $date)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');
        return $revenues;
    }


    public static function getSignupsAgeCountryRevenue($signdate, $date, $year, $age, $lang)
    {
        $nextyear = $year;
        if($date > 12){
            $date = sprintf('%02d', $date - 12);
            $nextyear = 2018;
        }

        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";

        $revenues =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $signdate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('customer_attributes.identifier', '=','user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->where('orders.currency', '=', $lang)
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $date)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');
        return $revenues;
    }

    public static function getSignupsWeek($date)
    {
        $week_number = $date;
        $year = date('Y');
        $first_day = date('Y-m-d 00:01:00', $week_number * 7 * 86400 + strtotime('1/1/' . $year) - date('w', strtotime('1/1/' . $year)) * 86400 + 86400);
        $last_day = date('Y-m-d 23:59:00', ($week_number + 1) * 7 * 86400 + strtotime('1/1/' . $year) - date('w', strtotime('1/1/' . $year)) * 86400);
        $customers = Plan::whereBetween('created_at', [$first_day, $last_day])->count();
        return $customers;
    }
    public static function getCohorts($signDate, $month, $year)
    {
        $allCustomers = Plan::getSignups($signDate, $year);
        $nextyear = $year;
        if($month > 12){
            $month = sprintf('%02d', $month - 12);
            $nextyear = 2018;
        }
        $customers = $allCustomers - Plan::whereMonth('created_at', '=', $signDate)->whereYear('created_at', '=', $year)->whereDate('subscription_cancelled_at', '<=', $nextyear."-".$month."-31")->count() /*+ DatesSubscribe::whereMonth('subscription_started_at', '=', $signDate)->whereMonth('subscription_cancelled_at', '<=', $month)->count()*/;
        if ($allCustomers == 0) {
            $cohorts = 100;
        } else {
            $cohorts = round(($customers / $allCustomers) * 100, 2);
        }
        $data = new Stat();
        $data->customers = $customers;
        $data->cohorts = $cohorts;
        return $data;
    }

    public static function getCohortsAge($signDate, $month, $year, $age, $all)
    {

       
        $allCustomers = $all;
        $nextyear = $year;
        if($month > 12){
            $month = sprintf('%02d', $month - 12);
            $nextyear = 2018;
        }

        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";

        $subs = Plan::select('plans.id')
            ->join('customers', 'customers.plan_id', '=', 'plans.id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->whereDate('plans.subscription_cancelled_at', '<=', $nextyear."-".$month."-31")
            ->where('customer_attributes.identifier', '=','user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->count();


        $customers = $allCustomers - $subs;
        if ($allCustomers == 0) {
            $cohorts = 100;
        } else {
            $cohorts = round(($customers / $allCustomers) * 100, 2);
        }
        $data = new Stat();
        $data->customers = $customers;
        $data->cohorts = $cohorts;

        return $data;
    }



    public static function getCohortsAgeCountry($signDate, $month, $year, $lang, $age, $all)
    {
        $allCustomers = $all;
        $nextyear = $year;
        if($month > 12){
            $month = sprintf('%02d', $month - 12);
            $nextyear = 2018;
        }

        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";

        $subs = Plan::select('plans.id')
            ->join('customers', 'customers.plan_id', '=', 'plans.id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('plans.currency', '=', $lang)
            ->whereDate('plans.subscription_cancelled_at', '<=', $nextyear."-".$month."-31")
            ->where('customer_attributes.identifier', '=','user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->count();

        $customers = $allCustomers - $subs;
        if ($allCustomers == 0) {
            $cohorts = 100;
        } else {
            $cohorts = round(($customers / $allCustomers) * 100, 2);
        }
        $data = new Stat();
        $data->customers = $customers;
        $data->cohorts = $cohorts;

        return $data;
    }


    public static function getCohortsCountry($signDate, $month, $year, $lang)
    {
        $allCustomers = Plan::getSignupsCountry($signDate, $year, $lang);
        $nextyear = $year;
        if($month > 12){
            $month = sprintf('%02d', $month - 12);
            $nextyear = 2018;
        }
        $customers = $allCustomers - Plan::whereMonth('created_at', '=', $signDate)->whereYear('created_at', '=', $year)->whereDate('subscription_cancelled_at', '<=', $nextyear."-".$month."-31")->where('currency', $lang)->count() /*+ DatesSubscribe::whereMonth('subscription_started_at', '=', $signDate)->whereMonth('subscription_cancelled_at', '<=', $month)->count()*/;
        if ($allCustomers == 0) {
            $cohorts = 100;
        } else {
            $cohorts = round(($customers / $allCustomers) * 100, 2);
        }
        $data = new Stat();
        $data->customers = $customers;
        $data->cohorts = $cohorts;
        return $data;
    }
    public static function getCohortsRevenue($signDate, $month, $year)
    {
        $revenue_all = Plan::getSignupsRevenue($signDate,$month, $year);
        $nextyear = $year;
        if($month > 12){
            $month = sprintf('%02d', $month - 12);
            $nextyear = 2018;
        }
        $ordersNl =  Order::select('orders.total')
                ->join('customers', 'customers.id', '=', 'orders.customer_id')
                ->join('plans', 'plans.id', '=', 'customers.plan_id')
                ->whereMonth('plans.created_at', '=', $signDate)
                ->whereYear('plans.created_at', '=', $year)
                // ->whereDate('plans.subscription_cancelled_at', '<=', $nextyear."-".$month."-31 00:00:00")
                ->where('orders.currency', '=', 'EUR')
                ->where('orders.state','=','sent')
                ->whereNull('orders.repeat')
                ->whereMonth('orders.created_at', '=', $month)
                ->whereYear('orders.created_at', '=', $nextyear)
                ->sum('orders.total') * 7.50;

        $ordersDk =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            //->whereDate('plans.subscription_cancelled_at', '<=', $nextyear."-".$month."-31 00:00:00")
            ->where('orders.currency', '=', 'DKK')
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $month)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');
        if ($revenue_all == 0) {
            $cohorts = 0;
        } else {
            $cohorts = $revenue_all - ($ordersNl + $ordersDk);
        }
        return $ordersNl + $ordersDk;
    }


    public static function getCohortsAgeRevenue($signDate, $month, $year, $age)
    {
        //$revenue_all = Plan::getSignupsAgeRevenue($signDate,$month, $year, $age);

        $nextyear = $year;
        if($month > 12){
            $month = sprintf('%02d', $month - 12);
            $nextyear = 2018;
        }

        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";

        $ordersNl =  Order::select('orders.total')
                ->join('customers', 'customers.id', '=', 'orders.customer_id')
                ->join('plans', 'plans.id', '=', 'customers.plan_id')
                ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
                ->whereMonth('plans.created_at', '=', $signDate)
                ->whereYear('plans.created_at', '=', $year)
                ->where('customer_attributes.identifier', '=','user_data.birthdate')
                ->whereBetween('customer_attributes.value',[$date_start, $date_end])
                ->where('orders.currency', '=', 'EUR')
                ->where('orders.state','=','sent')
                ->whereNull('orders.repeat')
                ->whereMonth('orders.created_at', '=', $month)
                ->whereYear('orders.created_at', '=', $nextyear)
                ->sum('orders.total') * 7.50;

        $ordersDk =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('customer_attributes.identifier', '=','user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->where('orders.currency', '=', 'DKK')
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $month)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');

        return $ordersNl + $ordersDk;
    }



    public static function getCohortsCountryRevenue($signDate, $month, $year, $lang)
    {
        $allCustomers = Plan::getSignupsCountryRevenue($signDate, $month, $year, $lang);
        $nextyear = $year;
        if($month > 12){
            $month = sprintf('%02d', $month - 12);
            $nextyear = 2018;
        }
        $orders =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            // ->whereDate('plans.subscription_cancelled_at', '<=', $nextyear."-".$month."-31")
            ->where('orders.currency', '=', $lang)
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $month)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');
        $revenues = $allCustomers - $orders;
        if ($allCustomers == 0) {
            $cohorts = 0;
        } else {
            $cohorts = $revenues;
        }
        return $orders;
    }


    public static function getCohortsAgeCountryRevenue($signDate, $month, $year, $age, $lang)
    {


        $nextyear = $year;
        if($month > 12){
            $month = sprintf('%02d', $month - 12);
            $nextyear = 2018;
        }

        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";

        $orders =  Order::select('orders.total')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('customer_attributes.identifier', '=','user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->where('orders.currency', '=', $lang)
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $month)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->sum('orders.total');

        return $orders;
    }





    public static function getCohortsArpu($signDate,$date, $year){


        $rev = Plan::getCohortsRevenue($signDate,$date, $year);

        $nextyear = $year;
        if($date > 12){
            $date = sprintf('%02d', $date - 12);
            $nextyear = 2018;
        }

        $orders = Order::whereNull('orders.repeat')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('orders.state','=','sent')
            ->whereMonth('orders.created_at', '=', $date)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->groupBy('orders.customer_id')
            ->get();

        $data = new Stat();

        if($rev > 0){


            $data->rev = $rev / count($orders);
            $data->count = count($orders);

            return $data;
        }

        $data->rev = 0;
        $data->count = 0;

        return $data;

    }


    public static function getCohortsAgeArpu($signDate,$date, $year, $age){




        $rev = Plan::getCohortsAgeRevenue($signDate,$date, $year, $age);

        $nextyear = $year;
        if($date > 12){
            $date = sprintf('%02d', $date - 12);
            $nextyear = 2018;
        }

        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";


        $orders = Order::whereNull('orders.repeat')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('customer_attributes.identifier', '=','user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->where('orders.state','=','sent')
            ->whereMonth('orders.created_at', '=', $date)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->groupBy('orders.customer_id')
            ->get();

        $data = new Stat();

        if($rev > 0){


            $data->rev = $rev / count($orders);
            $data->count = count($orders);

            return $data;
        }

        $data->rev = 0;
        $data->count = 0;

        return $data;

    }


    public static function getCohortsAgeCountryArpu($signDate,$date, $year, $age, $lang){




        $rev = Plan::getCohortsAgeCountryRevenue($signDate,$date, $year, $age, $lang);

        $nextyear = $year;
        if($date > 12){
            $date = sprintf('%02d', $date - 12);
            $nextyear = 2018;
        }

        if($age == 50){
            $date_start = "1930-01-01";
        } else{
            $date_start = (string)(2000 - $age)."-01-01";
        }
        $date_end = (string)(2000 + 10 - $age)."-01-01";


        $orders = Order::whereNull('orders.repeat')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->join('customer_attributes', 'customer_attributes.customer_id', '=', 'customers.id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('customer_attributes.identifier', '=','user_data.birthdate')
            ->whereBetween('customer_attributes.value',[$date_start, $date_end])
            ->where('orders.state','=','sent')
            ->where('orders.currency', '=', $lang)
            ->whereMonth('orders.created_at', '=', $date)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->groupBy('orders.customer_id')
            ->get();

        $data = new Stat();

        if($rev > 0){


            $data->rev = $rev / count($orders);
            $data->count = count($orders);

            return $data;
        }

        $data->rev = 0;
        $data->count = 0;

        return $data;

    }


    public static function getCohortsCountryArpu($signDate, $month, $year, $lang){


        $rev = Plan::getCohortsCountryRevenue($signDate, $month, $year, $lang);

        $nextyear = $year;
        if($month > 12){
            $month = sprintf('%02d', $month - 12);
            $nextyear = 2018;
        }

        $orders = Order::select('orders.customer_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('plans', 'plans.id', '=', 'customers.plan_id')
            ->whereMonth('plans.created_at', '=', $signDate)
            ->whereYear('plans.created_at', '=', $year)
            ->where('orders.currency', '=', $lang)
            ->where('orders.state','=','sent')
            ->whereNull('orders.repeat')
            ->whereMonth('orders.created_at', '=', $month)
            ->whereYear('orders.created_at', '=', $nextyear)
            ->groupBy('orders.customer_id')
            ->get();

        $data = new Stat();

        if($rev > 0){


            $data->rev = $rev / count($orders);
            $data->count = count($orders);

            return $data;
        }

        $data->rev = 0;
        $data->count = 0;

        return $data;

    }




    public static function getCohortsWeek($week, $signDate)
    {
        $week_number = $week;
        $year = date('Y');
        $first_day = date('Y-m-d 00:01:00', $week_number * 7 * 86400 + strtotime('1/1/' . $year) - date('w', strtotime('1/1/' . $year)) * 86400 + 86400);
        $last_day = date('Y-m-d 23:59:00', ($week_number + 1) * 7 * 86400 + strtotime('1/1/' . $year) - date('w', strtotime('1/1/' . $year)) * 86400);
        $sub_day = date('Y-m-d', $signDate * 7 * 86400 + strtotime('1/1/' . $year) - date('w', strtotime('1/1/' . $year)) * 86400);
        $allCustomers = Plan::getSignupsWeek($week);
        $customers = $allCustomers - Plan::whereBetween('created_at', [$first_day, $last_day])->where('subscription_cancelled_at', '<=', $sub_day)->count()/* + DatesSubscribe::whereBetween('subscription_started_at', [$first_day, $last_day])->whereMonth('subscription_cancelled_at', '<=', sprintf('%02d', $signDate))->count()*/;
        if ($allCustomers == 0) {
            $cohorts = 100;
        } else {
            $cohorts = round(($customers / $allCustomers) * 100, 2);
        }
        return $customers." (".$cohorts."%)";
    }
    public function getVitamins()
    {
        $vitamins = json_decode($this->vitamins);
        if (is_null($vitamins)) {
            return false;
        }
        return $vitamins;
    }
    public function getCouponCount()
    {
        return $this->coupon_free;
    }
    public function setCouponCount($count)
    {
        $this->coupon_free = $count;
        $this->save();
    }
    public function setDiscountCount($count)
    {
        $this->count_discount = $count;
        $this->save();
    }
    public function getDiscountCount()
    {
        return $this->count_discount;
    }
    public function clearPriceDiscount()
    {
        $this->price_discount = 0;
        $this->save();
    }
    public function setDiscountType($type)
    {
        $this->discount_type = $type;
        $this->save();
    }
    public function getReferalCount()
    {
        return $this->referal;
    }
    public function setReferalCount()
    {
        $this->referal = $this->getReferalCount() + 1;
        $this->save();
        return true;
    }
    public function setLastCoupon($code)
    {
        $this->last_coupon = $code;
        $this->save();
    }
    public function clearDiscount()
    {
        $this->coupon_free = 0;
        $this->discount_type = '';
        $this->save();
    }
    public function getLastCoupon()
    {
        return $this->last_coupon;
    }
    public function getDiscountType()
    {
        return $this->discount_type;
    }
    public function hasChiaoil()
    {
        $vitamins = json_decode($this->vitamins);
        if (is_null($vitamins)) {
            return false;
        }
        return Vitamin::whereIn('id', $vitamins)->where('code', '3g')->limit(1)->count() === 1; // todo unhardcode the 3e code
    }
    public function isSnoozed()
    {
        if (!is_null($this->getSubscriptionSnoozedUntil()) && Date::createFromFormat('Y-m-d H:i:s', $this->getSubscriptionSnoozedUntil())
                ->diffInSeconds() <= 0
        ) {
            $this->subscription_snoozed_until = null;
            $this->save();
        }
        return !is_null($this->getSubscriptionSnoozedUntil());
    }
    public function snooze($days)
    {
        $newDate = Date::parse($days . "14:10:00");
        $this->subscription_snoozed_until = $newDate;
        $this->subscription_rebill_at = $newDate;
        $this->save();
        return true;
    }
    public function moveRebill($days = 1)
    {
        if ($this->attempt == 14) {
            $this->cancel('14 days expired');
            return true;
        }
        $this->attempt = $this->attempt + 1;
        $this->subscription_rebill_at = Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt())->addWeekday($days);
        $this->save();
        return true;
    }
    public function setNewRebill($date)
    {
        if (!empty($date)) {
            $this->subscription_rebill_at = Date::createFromFormat('Y-m-d', $date);
            $this->save();
        }
        return true;
    }
    public function isSnoozeable()
    {
        return $this->isActive()
            //&& ! $this->isSnoozed()
            && Date::createFromFormat('Y-m-d H:i:s', $this->created_at)->diffInDays() >= 1
            && Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt())->diffInDays() >= 1;
    }
    public function isCancelable()
    {
        if(!$this->getRebillAt()){
            return false;
        }
        return Date::createFromFormat('Y-m-d H:i:s', $this->created_at)->diffInDays() >= 1
            && Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt())->diffInDays() >= 1
            && Date::createFromFormat('Y-m-d H:i:s', $this->getRebillAt()) > Date::now();
    }
    public function setNewUnsubscribe()
    {
        $uDate = new DatesSubscribe();
        $uDate->customer_id = $this->customer->id;
        $uDate->subscription_cancelled_at = $this->subscription_cancelled_at;
        $uDate->subscription_started_at = $this->subscription_started_at;
        $uDate->save();
    }
    public function delNewUnsubscribe()
    {
        $unsubscriber = DatesSubscribe::where('subscription_cancelled_at', '=', $this->subscription_cancelled_at);
        $unsubscriber->delete();
    }
    public function cancel($reason = '')
    {
        $this->subscription_snoozed_until = null;
        $this->subscription_cancelled_at = Date::now();
        $this->old_rebill_at = $this->subscription_rebill_at;
        $this->subscription_rebill_at = null;
        $this->unsubscribe_reason = $reason;
        $this->setNewUnsubscribe();
        $this->save();
        $customer = $this->customer;
        \App::setLocale($customer->getLocale());
        if ($customer->getLocale() == 'nl') {
            $fromEmail = 'info@takedaily.nl';
        } else {
            $fromEmail = 'info@takedaily.dk';
        }
        $mailEmail = $customer->getUser()->getEmail();
        $mailName = $customer->getUser()->getName();
        $mailCount = new MailStat();
        $mailCount->setMail(5);
        \Mail::queue('emails.cancel', ['locale' => $customer->getLocale(), 'reason' => $reason, 'name' => $customer->getFirstname()], function (Message $message) use ($mailEmail, $mailName, $customer, $fromEmail) {
            $message->from($fromEmail, 'TakeDaily')
                ->to($mailEmail, $mailName)
                ->subject(trans('mails.cancel.subject'));
        });
        return true;
    }
    public function start()
    {
        if (Date::createFromFormat('Y-m-d H:i:s', $this->subscription_cancelled_at)->diffInDays() >= 14) {
            $this->subscription_started_at = Date::now();
        }
        if (Date::createFromFormat('Y-m-d H:i:s', $this->subscription_cancelled_at)->diffInMonths() < 1) {
            $this->delNewUnsubscribe();
        }
        $this->subscription_snoozed_until = null;
        $this->subscription_cancelled_at = null;
        $this->subscription_rebill_at = Date::now()->addDays(28);
        //$this->subscription_rebill_at     = Date::now()->addDays( 28 );
        $this->save();
        return true;
    }
    public function setLastPaymentDate(){
        $this->last_rebill_date = Date::createFromFormat('Y-m-d H:i:s', $this->subscription_rebill_at)->subDay();
        $this->save();
        return true;
    }
    public function rebilled()
    {
        $this->attempt = 0;
        $this->subscription_rebill_at = Date::now()->addDays(28);
        $this->subscription_snoozed_until = null;
        $this->save();
        $this->markHasNotified(false);
        return true;
    }
    public function setSnoozingDate()
    {
        $this->snoozing_at = Date::now();
        $this->save();
        return true;
    }
    public function startFromToday()
    {
        if (Date::createFromFormat('Y-m-d H:i:s', $this->subscription_cancelled_at)->diffInDays() >= 14) {
            $this->subscription_started_at = Date::now();
        }
        if (Date::createFromFormat('Y-m-d H:i:s', $this->subscription_cancelled_at)->diffInMonths() < 1) {
            $this->delNewUnsubscribe();
        }
        $this->subscription_snoozed_until = null;
        $this->subscription_cancelled_at = null;
        $this->unsubscribe_reason = '';
        if ($this->old_rebill_at > Date::now()) {
            $this->subscription_rebill_at = $this->old_rebill_at;
        } else {
            $this->subscription_rebill_at = Date::now();
        }
        $this->old_rebill_at = null;
        $this->save();
        return true;
    }
    public function getSubscriptionSnoozedUntil()
    {
        return $this->subscription_snoozed_until;
    }
    public function getSubscriptionCancelledAt()
    {
        return $this->subscription_cancelled_at;
    }
    public function getReasonCancel()
    {
        return $this->unsubscribe_reason;
    }
    public function getSubscriptionStartedAt()
    {
        return $this->subscription_started_at;
    }
    public function getRebillAt()
    {
        return $this->subscription_rebill_at;
    }
    public function getNextDelivery()
    {
        return (new Date($this->getRebillAt()))->addDays(5)->format('Y-m-d');
    }
    public function getStartNextDeliveryNl()
    {
        return (new Date($this->getRebillAt()))->addWeekdays(2)->format('Y-m-d');
    }
    public function getEndNextDeliveryNl()
    {
        return (new Date($this->getRebillAt()))->addWeekdays(5)->format('Y-m-d');
    }
    public function getStartNextDeliveryDk()
    {
        return (new Date($this->getRebillAt()))->addWeekdays(3)->format('Y-m-d');
    }
    public function getEndNextDeliveryDk()
    {
        return (new Date($this->getRebillAt()))->addWeekdays(7)->format('Y-m-d');
    }
    public function getTotal()
    {
        return $this->getPrice() + $this->getShippingPrice();
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($newamount)
    {
        $this->price = $newamount;
        $this->save();
        return true;
    }
    public function setTrial(){
        $this->trial = 1;
        $this->save();
    }
    public function clearTrial(){
        $this->trial = 0;
        $this->save();
    }
    public function getShippingPrice()
    {
        return $this->price_shipping;
    }
    public function getPriceDiscount()
    {
        return $this->price_discount;
    }
    public function getStripeToken() // todo remove
    {
        return $this->stripe_token;
    }
    public function getPaymentCustomerToken()
    {
        return $this->payment_customer_token;
    }
    /**
     * Returns the payment method
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }
    public function getPaymentCustomer()
    {
        $customerToken = $this->getPaymentCustomerToken();
        $paymentMethod = new PaymentHandler(PaymentDelegator::getMethod($this->getPaymentMethod()));
        return $paymentMethod->getCustomer($customerToken);
    }
    public function getPaymentHandler()
    {
        $paymentMethod = new PaymentHandler(PaymentDelegator::getMethod($this->getPaymentMethod()));
        return $paymentMethod;
    }
    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeRebillPending($query)
    {
        return $query->where('subscription_rebill_at', '<=', Date::now()->addDays(3))
            ->where(function ($where) {
                $where->whereNull('subscription_snoozed_until')
                    ->orWhere('subscription_snoozed_until', '<=', Date::now()->addDays(3));
            })
            ->whereNull('subscription_cancelled_at');
    }
    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeNotNotifiedPending($query)
    {
        return $query->where('has_notified_pending_rebill', 0);
    }
    private function markHasNotified($hasNotified = true)
    {
        $this->has_notified_pending_rebill = $hasNotified ? 1 : 0;
        $this->save();
    }
    /**
     * @return bool
     */
    public function notifyUserPendingRebill()
    {
        $customer = $this->customer;
        \App::setLocale($customer->getLocale());
        if ($customer->getLocale() == 'nl') {
            $fromEmail = 'info@takedaily.nl';
            $url = "https://takedaily.nl/account/transactions?already_open=1";
        } else {
            $fromEmail = 'info@takedaily.dk';
            $url = "https://takedaily.dk/account/transactions?already_open=1";
        }
        $image = 'https://takedaily.nl/checksnooz/' . base64_encode($customer->getEmail()) . '/' . rand(1, 999) . '/email.png';
        \Mail::send('emails.pending-rebill', ['locale' => $customer->getLocale(), 'rebillAt' => $this->getRebillAt(), 'name' => $customer->getFirstname(), 'link' => $url, 'image' => $image], function (Message $message) use ($customer, $fromEmail) {
            \Log::info("Message send to " . $customer->getName() . "(id " . $customer->id . ", mail " . $customer->getEmail() . ")");
            $message->from($fromEmail, 'TakeDaily')
                ->to($customer->getEmail(), $customer->getName())
                ->subject(trans('mails.pending.subject'));
        });
        $snoozing = new Snoozing();
        $snoozing->customer_id = $customer->id;
        $snoozing->email = $customer->getEmail();
        $snoozing->save();
        $this->setSnoozingDate();
        $this->markHasNotified();
        return true;
    }
    public function isCustom()
    {
        return $this->is_custom == 1;
    }
    public function setIsCustom($isCustom = false)
    {
        $this->is_custom = $isCustom ? 1 : 0;
        $this->save();
        return true;
    }
    public function getPackage()
    {
        // todo
    }
    public function setNullSnooze()
    {
        $this->subscription_snoozed_until = null;
        $this->save();
        return true;
    }
}