<?php

namespace App\Http\Controllers;

use App\Apricot\Repositories\CouponRepository;
use App\Customer;
use Illuminate\Http\Request;

class ReactivateController extends Controller
{

    public function indexReactivate ($hash){

        $id = base64_decode($hash);

        $customer = Customer::where('id',$id)->first();

        if(!$customer){
            return \Redirect::home();
        }

        if ($customer->getPlan()->isActive()) {
            return \Redirect::home();
        }

        return view('account.reactivate', [
            'id' => $id
        ]);

    }



    public function getReactivate (Request $request){

        $data = $request->all();

        if($data){

            $id = $data['customer_id'];

            $customer = Customer::find($id);

            if(!$customer){
                return \Redirect::back();
            }


            if ($customer->getPlan()->isActive()) {
                return \Redirect::back();
            }

            $customer->getPlan()->start();

            return redirect()->home()->with('success', trans('messages.successes.subscription.started'));
        }

        return \Redirect::back();

    }



    public function applyCoupon(CouponRepository $couponRepository, Request $request)
    {



        // todo use a checkout model
        if (is_null($request->get('coupon')) || $request->get('coupon') == '') {
            return \Response::json(['message' => trans('checkout.messages.coupon-missing')], 400);
        }
        $coupon = $couponRepository->findByCouponForSecond($request->get('coupon'));

        if (!$coupon) {
            \Session::forget('applied_coupon');
            return \Response::json(['message' => trans('checkout.messages.no-such-coupon')], 400);
        }

        $customer = Customer::find($request->get('id'));

        $plan = $customer->getPlan();

//        if($plan->last_coupon == $coupon->code or  $plan->coupon_free != ''){
//            return \Response::json(['message' => trans('checkout.messages.coupon-missing')], 400);
//        }

        $plan->last_coupon = $coupon->code;
        if($coupon->discount_type == 'percentage'){
            $plan->discount_type = 'percent';
        } else{
            $plan->discount_type = 'month';
        }

        $plan->coupon_free = $coupon->discount;
        $coupon->reduceUsagesLeft();
        $plan->update();


        return \Response::json([
            'message' => trans('checkout.messages.coupon-added'),
            'coupon' => [
                'description' => $coupon->description,
                'applies_to' => $coupon->applies_to,
                'discount_type' => $coupon->discount_type,
                'discount' => $coupon->discount,
                'code' => $coupon->code
            ]
        ], 200);
    }



}


