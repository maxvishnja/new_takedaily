<?php namespace App\Apricot\Payment;

use App\Apricot\Interfaces\PaymentInterface;
use App\Apricot\Libraries\MoneyLibrary;

class Mollie implements PaymentInterface
{
    /**
     * @param int $amount
     * @param string $description
     * @param array $data
     *
     * @return \Mollie_API_Object_Payment
     */


    public static function checkConnection(){

        return \Mollie::api()->methods()->all();
    }


    public function charge($amount, $description, $data = [])
    {
        if ($amount <= 0) {
            $amount = config('app.minimum_orders.mollie') * 100;
        }

        $charge = [
            "amount" => MoneyLibrary::toMoneyFormat($amount, true, 3, '.', ''),
            "description" => $description,
            "redirectUrl" => \URL::route('checkout-verify-method', ['method' => 'mollie','id' => $data['customerId']])
        ];

        $charge = array_merge($charge, $data);

        try {
            return \Mollie::api()->payments()->create($charge);

        } catch (\Exception $exception) {

            \Log::error("Mollie payment charge create error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());
            return false;
        }

    }

    /**
     * @param string $name
     * @param string $email
     *
     * @return \Mollie_API_Object_Customer
     */
    public function createCustomer($name, $email)
    {

        try {

            return \Mollie::api()->customers()->create([
                "name" => $name,
                "email" => $email,
            ]);

        } catch (\Exception $exception) {

            \Log::error("Mollie customer create error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());
            return false;
        }
    }

    /**
     * @param int $amount
     * @param \Mollie_API_Object_Customer $customer
     *
     * @return \Mollie_API_Object_Payment
     */
    public function makeFirstPayment($amount, $customer)
    {
        \Log::info("Mollie first payment OK: " .  $customer->id);

        return $this->charge($amount, 'Initial', [
            'customerId' => $customer->id,
            "method" => 'ideal',
            'recurringType' => 'first'
        ]);
    }

    /**
     * @param int $amount
     * @param \Mollie_API_Object_Customer $customer
     *
     * @return bool|\Mollie_API_Object_Payment
     */
    public function makeRebill($amount, $customer)
    {
        $mandates = \Mollie::api()->customersMandates()->withParentId($customer->id)->all();

        $hasValidMandate = false;

        /** @var \Mollie_API_Object_Customer_Mandate $mandate */
        foreach ($mandates as $mandate) {
            if ($mandate->isValid()) {
                $hasValidMandate = true;
            }
        }

        if (!$hasValidMandate) {
            return false;
        }
        \Log::info("Mollie rebill OK: " .  $customer->id);

        return $this->charge($amount, 'Rebill', [
            'customerId' => $customer->id,
            "method" => 'directdebit',
            'recurringType' => 'recurring'
        ]);
    }

    /**
     * @param $chargeId
     *
     * @return bool
     */
    public function validateCharge($chargeId)
    {
        /** @var \Mollie_API_Object_Payment $payment */
        $payment = $this->findOrder($chargeId);

        return $payment->isPaid();
    }


    public function refundPayment ($chargeId) {

        try{

            $payments = \Mollie::api()->customersPayments()->withParentId($chargeId)->all();

                    $order = $this->findOrder($payments['0']->id);

            if($order->isPaid()){

                return \Mollie::api()->payments()->refund($order);

            } else{

                return false;
            }



        } catch (\Exception $exception) {

            \Log::error("Mollie refund error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());
            return false;
        }

    }



    /**
     * @param $orderId
     *
     * @return \Mollie_API_Object_Payment
     */
    public function findOrder($orderId)
    {
        return \Mollie::api()->payments()->get($orderId);
    }

    /**
     * @param $customerId
     *
     * @return \Mollie_API_Object_Customer
     */
    public function findCustomer($customerId)
    {
        return \Mollie::api()->customers()->get($customerId);
    }

    public function addMethod($source, $customer)
    { // todo.. find a way to disable this for Mollie and instead require a new first transaction..
        return \Mollie::api()->customersMandates()->withParentId($customer->id)->create([

        ]);
    }

    public function getCustomerMethods($customerId)
    {
        $validMandates = [];

        try {
            $mandates = \Mollie::api()->customersMandates()->withParentId($customerId)->all();
        } catch (\Exception $exception) {
            return $validMandates;
        }

        /** @var \Mollie_API_Object_Customer_Mandate $mandate */
        foreach ($mandates as $mandate) {
            if ($mandate->isValid()) {
                $validMandates[] = $mandate;
            }
        }

        return $validMandates;
    }

    /**
     * @param $customerId
     *
     * @return array
     */
    public function deleteMethodFor($customerId)
    {
        // no implementation to do this.
        return ['purge_plan' => true];
    }
}