<?php namespace App\Http\Controllers;

use App\Apricot\Libraries\PillLibrary;
use App\Customer;
use App\MailStat;
use App\Nutritionist;
use App\User;
use App\Vitamin;
use Illuminate\Http\Request;
use Stripe\Error\Card;
use App\Apricot\Repositories\CouponRepository;

class AccountController extends Controller
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var Customer
     */
    private $customer;

    function __construct()
    {
        $this->middleware('user');
        $this->user = \Auth::user();
        if ($this->user && $this->user->getCustomer()) {
            $this->customer = $this->user->getCustomer();
            \App::setLocale($this->user->getCustomer()->getLocale());
            \View::share('customer', $this->customer);
        }

    }


    function getHome()
    {



        $plan = $this->customer->getPlan();
        $orders = $this->customer->getOrders();

        $nutritionist = Nutritionist::where('id', $plan->nutritionist_id)
            ->where('active', 1)
            ->first();

        return view('account.my-takedaily', compact('orders', 'plan', 'nutritionist'));
    }

    public function getNutritionist()
    {

        $plan = $this->customer->getPlan();

        $nutritionist = Nutritionist::where('id', $plan->nutritionist_id)
            ->where('active', 1)
            ->first();

        return view('account.nutritionist', compact('nutritionist'));


    }

    public function postNutritionistEmail(Request $request){



            $data = $request->all();
            if($data){
                $nutritionist = Nutritionist::where('id', $this->customer->plan->nutritionist_id)
                    ->where('active', 1)
                    ->first();

                $mailEmail = $nutritionist->email;
                $fromEmail = $this->customer->getUser()->getEmail();
                $data['name']  = $this->customer->getUser()->getName();
                $data['n_name']  = $nutritionist->first_name." ".$nutritionist->last_name;
                $data['locale']  = $this->customer->getLocale();
                $mailName = 'TakeDaily';
                $locale = \App::getLocale();


                \Mail::send('emails.nutritionist', $data,
                    function ($message)
                    use ($mailEmail, $mailName, $locale, $fromEmail) {
                        \App::setLocale($locale);
                        $message->from($fromEmail, 'TakeDaily');
                        $message->to($mailEmail, $mailName);
                        //$message->subject($fromEmail);
                        $message->subject(trans('mails.nutritionist.subject'));
                    });

                return \Redirect::action('AccountController@getHome')->with('success', trans('messages.successes.nutritionist.email.sent'));

            }





    }

    function updatePreferences(Request $request)
    {
        if (!$this->customer || $this->customer->plan->isCustom()) {
            return redirect()->back()->withErrors(trans('account.general.errors.custom-package-cant-change'));
        }

        return redirect()->route('flow');
    }

    public function getCancelPage()
    {
        if (!$this->customer || !$this->customer->plan->isActive() || !$this->customer->plan->isCancelable()) {
            return redirect()->back();
        }

        return view('account.settings.cancel');
    }

    function updateVitamins()
    {
        $combinations = $this->user->getCustomer()->calculateCombinations();
        $vitamins = [];

        foreach ($combinations as $vitaminCode) {
            $vitamin = Vitamin::select('id')->whereCode($vitaminCode)->first();

            if ($vitamin) {
                $vitamins[] = $vitamin->id;
            }
        }

        $this->user->getCustomer()->getPlan()->update([
            'vitamins' => json_encode($vitamins)
        ]);

        // todo: Update price

        return \Redirect::action('AccountController@getHome')->with('success', trans('account.general.successes.vitamins-updated'));
    }

    function getTransactions()
    {
        return view('account.transactions', [
            'orders' => $this->customer->getOrders(),
            'plan' => $this->customer->getPlan()
        ]);
    }

    function getTransaction($id)
    {
        $order = $this->customer->getOrderById($id);

        if (!$order) {
            return \Redirect::to('/account/transactions')->withErrors(trans('messages.errors.transactions.not_found'));
        }

        return view('account.transaction', [
            'order' => $order
        ]);
    }

    function getSettingsBilling()
    {
        $sources = $this->customer->getPaymentMethods();

        return view('account.settings.billing', [
            'sources' => $sources['methods'],
            'method' => $sources['type'],
            'plan' => $this->customer->getPlan()
        ]);
    }

    function getSettingsBillingRemove()
    {
        if (!$this->customer->removePaymentOption()) {
            return redirect()->action('AccountController@getSettingsBilling')->withErrors(trans('messages.successes.billing.removing-failed'));
        }

        return redirect()->action('AccountController@getSettingsBilling')->with('success', trans('messages.successes.billing.removed'));
    }

    function getSettingsBillingAdd()
    {
        if (count($this->customer->getPaymentMethods()['methods']) > 0) {
            return \Redirect::action('AccountController@getSettingsBilling');
        }

        return view('account.settings.billing-add');
    }

    function postSettingsBillingAdd(Request $request)
    {
        $user = \Auth::user();

        if (count($this->customer->getPaymentMethods()['methods']) == 0) {
            try {
                $stripeCustomer = Customer::create([
                    "description" => "Customer for {$user->getEmail()}",
                    "source" => $request->get('stripeToken')
                ]);

                $user->getCustomer()->getPlan()->update([
                    'stripe_token' => $stripeCustomer->id
                ]);
            } catch (Card $ex) {
                return \Redirect::back()->withErrors([trans('checkout.messages.payment-error', ['error' => $ex->getMessage()])])->withInput();
            } catch (\Exception $ex) {
                return \Redirect::back()->withErrors([trans('checkout.messages.payment-error', ['error' => $ex->getMessage()])])->withInput();
            } catch (\Error $ex) {
                return \Redirect::back()->withErrors([trans('checkout.messages.payment-error', ['error' => $ex->getMessage()])])->withInput();
            }
        } else {
            $stripeCustomer = $user->getCustomer()->getStripeCustomer();
            try {
                $stripeCustomer->sources->create([
                    'source' => $request->get('stripeToken')
                ]);
            } catch (Card $ex) {
                return \Redirect::back()->withErrors([trans('checkout.messages.payment-error', ['error' => $ex->getMessage()])])->withInput();
            } catch (\Exception $ex) {
                return \Redirect::back()->withErrors([trans('checkout.messages.payment-error', ['error' => $ex->getMessage()])])->withInput();
            } catch (\Error $ex) {
                return \Redirect::back()->withErrors([trans('checkout.messages.payment-error', ['error' => $ex->getMessage()])])->withInput();
            }
        }

        return \Redirect::action('AccountController@getSettingsBilling')->with('success', trans('checkout.messages.success.card-added'));
    }

    function getSettingsBasic()
    {
        return view('account.settings.basic', [
            'attributes' => $this->customer->getCustomerAttributes(true)
        ]);
    }

    function postSettingsBasic(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'name' => 'required',
            'password' => 'confirmed'
        ]);

        foreach ($request->input('attributes') as $attributeId => $attributeValue) {
            $this->customer->customerAttributes()->where('id', $attributeId)->update(['value' => $attributeValue]);
        }

        $this->customer->birthday = $request->get('birthday');
        $this->customer->accept_newletters = $request->get('newsletters', 0);
        $this->customer->gender = $request->get('gender', 'Male');
        $this->user->email = $request->get('email');
        $this->user->name = $request->get('name');

        if ($request->get('password') != '') {
            $this->user->password = bcrypt($request->get('password'));
        }

        $this->customer->save();
        $this->user->save();

        return \Redirect::to('/account/settings/basic')->with('success', trans('messages.successes.profile.updated'));
    }

    function getSettingsSubscription()
    {
        return view('account.settings.subscription', [
            'plan' => $this->customer->getPlan()
        ]);
    }

    function postSettingsSubscriptionSnooze(Request $request)
    {
        if (!$this->customer->getPlan()->isSnoozeable()) {
            return redirect()->action('AccountController@getSettingsSubscription')->withErrors(trans('messages.errors.subscription.not-snoozed'));
        }

//		if ( $request->get( 'days', 7 ) > 28 )
//		{
//			return redirect()->back()->withErrors( trans( 'account.general.errors.max-snooze' ) );
//		}

        if($request->get('days') == ''){
            return redirect()->back()->withErrors( trans('messages.errors.subscription.not-snoozed'));
        }
        $this->customer->getPlan()->snooze($request->get('days'));

        \Log::info("Customer ID ".$this->customer->id." snoozed to " . $request->get('days'));


        $mailCount = new MailStat();

        $mailCount->setMail(4);

        $mailEmail = $this->customer->getUser()->getEmail();
        $mailName = $this->customer->getUser()->getName();
        $locale = \App::getLocale();
        $data['name'] = $mailName;
        $data['days'] = $request->get('days');

        if ($locale == 'nl') {
            $fromEmail = 'info@takedaily.nl';
        } else {
            $fromEmail = 'info@takedaily.dk';
        }

        \Mail::send('emails.snoozing', $data, function ($message) use ($mailEmail, $mailName, $locale, $fromEmail) {
            \App::setLocale($locale);
            $message->from($fromEmail, 'TakeDaily');
            $message->to($mailEmail, $mailName);
            $message->subject(trans('mails.snoozing.subject'));
        });

        return redirect()
            ->action('AccountController@getSettingsSubscription')
            ->with('success', trans('messages.successes.subscription.snoozed', ['days' => $request->get('days')]));
    }

    function getSettingsSubscriptionStart()
    {
        if ($this->customer->getPlan()->isActive()) {
            return \Redirect::back();
        }

        $this->customer->getPlan()->start();

        return redirect()->action('AccountController@getSettingsSubscription')->with('success', trans('messages.successes.subscription.started'));
    }

    function getSettingsSubscriptionRestart()
    {
        if ($this->customer->getPlan()->isActive()) {
            return \Redirect::back();
        }

        $this->customer->getPlan()->startFromToday();

        return redirect()->action('AccountController@getSettingsSubscription')->with('success', trans('messages.successes.subscription.started'));
    }

    function getSettingsSubscriptionCancel(Request $request)
    {

        if (!$this->customer->getPlan()->isCancelable()) {
            return redirect()->action('AccountController@getSettingsSubscription')->with('success', trans('messages.successes.subscription.cancelled'));
        }

        if ($request->get('reason') === '-1') {
            $reason = $request->get('other_reason');
        } elseif ($request->get('reason') == trans('account.settings_cancel.reasons.5')) {
            $reason = $request->get('reason') . ": " . $request->get('why_reason');

        } elseif ($request->get('reason') == trans('account.settings_cancel.reasons.0')) {
            $reason = $request->get('reason') . ": " . $request->get('other_firm');
        } else {
            $reason = $request->get('reason');
        }

        $this->customer->getPlan()->cancel($reason);

//        $mailEmail = $this->customer->getUser()->getEmail();
//        $mailName = $this->customer->getUser()->getName();
//        $locale = \App::getLocale();
//        $data['name'] = $mailName;
//
//        if ($locale == 'nl') {
//            $fromEmail = 'info@takedaily.nl';
//        } else {
//            $fromEmail = 'info@takedaily.dk';
//        }
//
//        \Mail::queue('emails.cancel', $data, function ($message) use ($mailEmail, $mailName, $locale, $fromEmail) {
//            \App::setLocale($locale);
//            $message->from($fromEmail, 'TakeDaily');
//            $message->to($mailEmail, $mailName);
//            $message->subject(trans('mails.cancel.subject'));
//        });

        return redirect()->action('AccountController@getSettingsSubscription')->with('success', trans('messages.successes.subscription.cancelled'));
    }

    public function updatePaymentMethod(Request $request)
    {
        $handler = $this->customer->getPlan()->getPaymentHandler();
        $customer = $this->customer->getPlan()->getPaymentCustomer();

        $handler->deleteMethodFor($customer->id);
        $handler->addMethodToCustomer($request->get('stripeToken'), $customer);

        return redirect()->action('AccountController@getSettingsBilling')->with('success', trans('messages.successes.paymentmethod.updated'));
    }

    public function getSeeRecommendation()
    {
        /** @var \App\FlowCompletion $flowCompletion */
        $flowCompletion = \App\FlowCompletion::generateNew(json_encode($this->customer->getUserData()));

        return redirect()->route('flow', ['token' => $flowCompletion->token]);
    }



    function applyCoupon(CouponRepository $couponRepository, Request $request)
    { // todo use a checkout model
        if (is_null($request->get('coupon')) || $request->get('coupon') == '') {
            return \Response::json(['message' => trans('checkout.messages.coupon-missing')], 400);
        }
        $coupon = $couponRepository->findByCouponForSecond($request->get('coupon'));

        if (!$coupon) {
            \Session::forget('applied_coupon');
            return \Response::json(['message' => trans('checkout.messages.no-such-coupon')], 400);
        }

        $plan = $this->customer->getPlan();

        if($coupon->code == 'UNDSKYLD'){
            if($plan->coupon_free != ''){
                return \Response::json(['message' => trans('checkout.messages.coupon-missing')], 400);
            }
        } else{
            if($plan->last_coupon == $coupon->code or $plan->coupon_free != ''){
                return \Response::json(['message' => trans('checkout.messages.coupon-missing')], 400);
            }
        }




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



    public function postSharedEmail(Request $request){


        if (\Request::ajax()) {

            $data = $request->all();

            $mailEmail = $data['to'];
            $fromEmail = $data['from'];
            $data['layout'] = 'layouts.pdf';
            $mailName = 'TakeDaily';
            $locale = \App::getLocale();

            \Mail::send('emails.shared', $data, function ($message) use ($mailEmail, $mailName, $locale, $fromEmail) {
                \App::setLocale($locale);
                $message->from($fromEmail, 'TakeDaily');
                $message->to($mailEmail, $mailName);
                $message->subject($fromEmail.' shared with you');
            });

        }


    }



}