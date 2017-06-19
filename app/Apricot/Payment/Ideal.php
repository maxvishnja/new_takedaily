<?php namespace App\Apricot\Payment;


use App\Apricot\Interfaces\PaymentInterface;
use Stripe\Card;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\Base;
use Stripe\Error\InvalidRequest;
use Stripe\Error\RateLimit;

class Ideal implements PaymentInterface
{
    function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET_KEY', ''));
    }

    public function findOrder($orderId)
    {
        return Charge::retrieve($orderId);
    }

    public function findCustomer($customerId)
    {
        return Customer::retrieve($customerId);
    }

    public static function checkConnection(){

        \Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET_KEY', ''));

        return \Stripe\CountrySpec::all(array("limit" => 1));;


    }


    public function charge($amount, $description, $data)
    {
        $charge = [
            "amount" => $amount,
            "description" => $description,
        ];

        $charge = array_merge($charge, $data);

        try {
            return Charge::create($charge);
        } catch (\Exception $exception) {

            \Log::error("Payment charge create error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());
            return false;
        }
    }

    public function finishedPayment($amount, $sourcecode, $customer)
    {
        $charge = [
            "amount" => $amount,
            'customer' => $customer,
            "description" => 'Initial',
            'currency' => trans('general.currency'),
            "source" => $sourcecode,
        ];

//        $charge = array_merge($charge, $data);

        try {

            return Charge::create($charge);

        } catch (\Exception $exception) {

            \Log::error("Payment charge create error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());
            return false;
        }
    }

    public function createCustomer($name, $email)
    {
        try {
            return Customer::create([
                'description' => "Customer for {$email}",
                'email' => $email,
                'source' => \Request::get('stripeToken', \Session::get('stripeToken'))
            ]);
        } catch (\Stripe\Error\Card $ex) {
            \Log::error("STRIPE card create error: " . $ex->getMessage() . ' in line ' . $ex->getLine() . " file " . $ex->getFile());
            return false;
        } catch (\Exception $ex) {
            \Log::error("STRIPE card2 create error: " . $ex->getMessage() . ' in line ' . $ex->getLine() . " file " . $ex->getFile());
            return false;
        } catch (\Error $ex) {
            \Log::error("STRIPE card3 create error: " . $ex->getMessage() . ' in line ' . $ex->getLine() . " file " . $ex->getFile());
            return false;
        }
    }



    public function createSource($amount, $data){

        $source = \Stripe\Source::create(array(
            "amount" => $amount,
            "currency" => $data['currency'],
            "type" => "ideal",
            "owner" => array(
                "email" => $data['email']
            ),
            "redirect" => array(
                "return_url" => \URL::route('checkout-verify-method', ['method' => 'mollie'])
            ),
        ));


        return $source;
    }

    public function makeFirstPayment($amount, $customer)
    {

        if ($amount == 0) {
            $charge = new \stdClass();
            $charge->id = 'giftcard-balance';

            return $charge;
        }

        \Log::info("Stripe first payment OK: " .  $customer->id);

        return $this->createSource($amount, [
            'currency' => trans('general.currency'),
            'customer' => $customer->id,
            'email' => $customer->email
        ]);
    }


    public function makeRebill($amount, $customer)
    {
        try {

            \Log::info("Stripe rebill OK: " .  $customer->id);

            return \Stripe\Invoice::create([
//                'amount' => $amount,
//                'currency' => trans('general.currency'),
                  'customer' => $customer->id,
//                'description' => 'rebill',
//                'statement_descriptor' => 'TakeDaily',
            ]);
        } catch (\Exception $exception) {

            echo "Ideal error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile();

            //return false;
        }
    }

    /**
     * @param $chargeId
     *
     * @return bool
     */
    public function validateCharge($chargeId)
    {


        if ($chargeId == 'giftcard-balance') {
            return true;
        }

        try {

            /** @var Charge $payment */
            $payment = $this->findOrder($chargeId);


            return $payment->status == 'succeeded';
        } catch (\Exception $exception) {
            \Log::error("STRIPE create error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());
            return false;
        }
    }

    /**
     * @param          $source
     * @param Customer $customer
     *
     * @return Card
     */
    public function addMethod($source, $customer)
    {
        try {
            return $customer->sources->create([
                'source' => $source
            ]);
        } catch (\Stripe\Error\Card $ex) {
            \Session::flash('error_message', $ex->getMessage());

            return false;
        } catch (\Exception $ex) {
            \Session::flash('error_message', $ex->getMessage());

            return false;
        } catch (\Error $ex) {
            \Session::flash('error_message', $ex->getMessage());

            return false;
        }
    }

    public function getCustomerMethods($customerId)
    {
        $customer = Customer::retrieve($customerId);

        $array = [];

        foreach ($customer->sources->all()->data as $source) {
            $array[] = $source;
        }

        return $array;
    }

    /**
     * @param $customerId
     *
     * @return array
     */
    public function deleteMethodFor($customerId)
    {
        $customer = $this->findCustomer($customerId);

        foreach ($customer->sources->all()->data as $source) {
            $source->delete();
        }

        return ['purge_plan' => false];
    }
}