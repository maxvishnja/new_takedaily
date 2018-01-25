<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\CustomerRepository;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Notes;
use App\Nutritionist;
use App\Order;
use App\User;
use App\Vitamin;
use Illuminate\Mail\Message;
use Illuminate\Http\Request;
use App\Http\Requests;

class CustomerController extends Controller
{

    private $repo;

    function __construct(CustomerRepository $repository)
    {
        $this->repo = $repository;
    }

    function index()
    {

        $customers = Customer::orderBy('created_at', 'DESC')->paginate(15);

        //$customers = $this->repo->all();
        $customers->load('user');

        return view('admin.customers.home', [
            'customers' => $customers
        ]);
    }



    function show($id)
    {

        $customer = Customer::find($id);

        if( ! $customer )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }

        $newusers = Order::where('coupon','=',$customer->coupon)
            ->whereBetween( 'created_at', [ \Date::now()->subMonth(), \Date::now() ] )
            ->count();

        $allnewusers = Order::where('coupon','=',$customer->coupon)->count();

        $customer->load([ 'user', 'customerAttributes', 'plan', 'orders' ]);


        $nutritionist = Nutritionist::find($customer->plan->nutritionist_id);

        return view('admin.customers.show', [
            'customer' => $customer,
            'newusers' => $newusers,
            'allnewusers' => $allnewusers,
            'nutritionist' => $nutritionist,

        ]);
    }

    function edit($id)
    {


        $customer = Customer::find($id);

        if( ! $customer )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }

        $newusers = Order::where('coupon','=',$customer->coupon)
            ->whereBetween( 'created_at', [ \Date::now()->subMonth(), \Date::now() ] )
            ->count();

        $allvitamins = \DB::table('ltm_translations')->where([['group', '=', 'pill-names'], ['locale', '=', 'nl']])->get();

        $nutritionist = Nutritionist::where('active','=',1)->where('locale', '=', $customer->getLocale())->get();

        $customer->load([ 'user', 'customerAttributes', 'plan', 'orders']);

        return view('admin.customers.edit', [
            'customer' => $customer,
            'allvit' => $allvitamins,
            'newusers' => $newusers,
            'nutritionist' => $nutritionist,
        ]);
    }



    function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        $order = Order::where([['state', '=', 'paid'],['customer_id', '=', $id]])->first();

        if( ! $customer )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }

        foreach($customer->customerAttributes as $ident){
            if($ident->identifier == 'user_data.birthdate'){
                $ident->value = $request->get('user_data_birthdate');
                $ident->update();
            }
            if($ident->identifier == 'phone'){
                $ident->value = $request->get('phone');
                $ident->update();
            }

            if($ident->identifier == 'company'){
                $ident->value = $request->get('company');
                $ident->update();
            }
            if($ident->identifier == 'address_line1'){
                $ident->value = $request->get('address_line1');
                if($order){
                    $order->shipping_street = $request->get('address_line1');
                    $order->update();
                }
                $ident->update();
            }
            if($ident->identifier == 'address_city'){
                $ident->value = $request->get('address_city');
                if($order) {
                    $order->shipping_city = $request->get('address_city');
                    $order->update();
                }
                $ident->update();
            }
            if($ident->identifier == 'address_country'){
                $ident->value = $request->get('address_country');
                if($order) {
                    $order->shipping_country = $request->get('address_country');
                    $order->update();
                }
                $ident->update();

            }
            if($ident->identifier == 'address_postal'){
                $ident->value = $request->get('address_postal');
                if($order) {
                    $order->shipping_zipcode = $request->get('address_postal');
                    $order->update();
                }
                $ident->update();
            }
            if($ident->identifier == 'user_data.age'){
                $ident->value = $customer->getAge();
                $ident->update();
            }
            if($ident->identifier == 'address_number'){
                $ident->value = $request->get('address_number');
                $ident->update();

            }

        }



        if($order) {
            $order->shipping_name = $request->get('cust_name');
            $order->update();
        }
        $usernew['name'] = $request->get('cust_name');
        $usernew['email'] = $request->get('cust_email');
        $customer->user->update($usernew);
        $customer->ambas = $request->get('ambas');
        $customer->coupon = $request->get('coupon');


        /*
         ** Add discount of ambassador
         */
        if($request->get('ambas')==1){
            $customer->plan->setCouponCount($request->get('coupon_free'));
            $customer->plan->setDiscountType($request->get('discount_type'));
            $customer->goal = $request->get('goal');
        }



        if($request->get('vitamin-1')){
            foreach($request->get('vitamin-1') as $vit1){
                $vitamins_one = Vitamin::where('code', '=', $vit1)->value('id');
            }
        }
        if($request->get('vitamin-2')){
            foreach($request->get('vitamin-2') as $vit2) {
                $vitamins_two = Vitamin::where('code', '=', strtoupper($vit2))->value('id');
            }
        }
        if($request->get('vitamin-3')){
            foreach($request->get('vitamin-3') as $vit3) {
                $vitamins_three[] = Vitamin::where('code', '=', $vit3)->value('id');
            }
        }

        if($request->get('new_vitamin')){

            $vitamins_new = Vitamin::where('code', '=', $request->get('new_vitamin'))->value('id');

        }

        $vitamins = [];

        if(isset($vitamins_one)) {
            $vitamins [] =  $vitamins_one ;
        }

        if(isset($vitamins_two)) {
            $vitamins [] =  $vitamins_two ;
        }

        if(isset($vitamins_three[0])) {
            $vitamins [] =  $vitamins_three[0];
        }

        if(isset($vitamins_three[1])) {
            $vitamins [] =  $vitamins_three[1];
        }
        if(isset($vitamins_new)) {
            $vitamins [] =  $vitamins_new;
        }

        if(!empty($vitamins)){
            $vitamins = json_encode($vitamins);
            $customer->plan->vitamins = $vitamins;
            $customer->plan->update();
        }

        if($request->get('rebill')){
            if($request->get('change-rebill') == 1) {
                \Log::info("Manually change rebill date of Customer id-" . $customer->id);
            }
            $customer->plan->setNewRebill($request->get('rebill'));
        }
        if($request->get('nutritionist')){
            $customer->plan->nutritionist_id = $request->get('nutritionist');
            $customer->plan->update();
        }


        $customer->update();

        return \Redirect::action('Dashboard\CustomerController@index')->with('success', 'Kunden er blevet ændret.');
    }

    function newPass($id)
    {
        $customer = Customer::find($id);

        if( ! $customer )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }

        $customer->load('user');
        $password = str_random(8);

        $customer->user->password = \Hash::make($password);
        $customer->user->save();

        \Mail::send('emails.new-password', [ 'locale' => \App::getLocale(), 'password' => $password ], function (Message $message) use ($customer)
        {
            $message->to($customer->user->getEmailForPasswordReset(), $customer->getName());
            $message->subject(trans('mails.new-password.subject'));
            $message->from('noreply@takedaily.com', 'TakeDaily');
        });

        return \Redirect::action('Dashboard\CustomerController@show', [ $id ])->with('success', 'Kunden har fået tilsendt en ny adgangskode!');
    }



    function addNote(Request $request, $id)
    {
        $note = new Notes();

        $note->customer_id = $id;
        $note->author = $request->get('author') == '' ? 'admin' : $request->get('author');
        $note->note = $request->get('note');
        $note->date = $request->get('date');
        $note->save();

        return \Redirect::back();

    }


    function cancel(Request $request)
    {
        $data = $request->all();

        $customer = Customer::find($data['id']);

        if( ! $customer )
        {
            return \Redirect::back()->withErrors("Kunden (#{$data['id']}) kunne ikke findes!");
        }

        $reason = "(from Dashboard) ".$data['reason'];

        if( ! $customer->cancelSubscription(true, $reason) )
        {
            return \Redirect::action('Dashboard\CustomerController@show', [ $data['id'] ])->withErrors('Kundens abonnent kunne ikke opsiges, fordi det allerede er opsagt.');
        }

        return \Redirect::back()->with('success', 'Kundens abonnent er blevet opsagt.');
    }

    function bill($id)
    {
        $customer = Customer::find($id);

        if( ! $customer )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }

        if ( ! $charge = $customer->rebill() )
        {
            return \Redirect::back()->withErrors("Der kunne ikke trækkes penge fra kunden!");
        }

        $lastOrder = $customer->orders()->latest()->first();

        return \Redirect::action('Dashboard\CustomerController@show', [ $id ])->with('success', "Der blev trukket penge fra kundens konto, og en ny ordre (#{$lastOrder->id}) blev oprettet. <a href=\"" . \URL::action('Dashboard\OrderController@show', [ $lastOrder->id ]) . "\">Vis ordre</a>");
    }


    function repeat($id)
    {
        $customer = Customer::find($id);

        if( ! $customer )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }

        if ( ! $charge = $customer->repeat() )
        {
            return \Redirect::back()->withErrors("Der kunne ikke trækkes penge fra kunden!");
        }

        $lastOrder = $customer->orders()->latest()->first();

        return \Redirect::action('Dashboard\CustomerController@show', [ $id ])->with('success', "A new order (#{$lastOrder->id}) has been created!");
    }

    function destroy($id)
    {
        $customer = Customer::find($id);

        if( ! $customer )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }


        $customer->delete();


        return \Redirect::action('Dashboard\CustomerController@index')->with('success', 'Kunden blev slettet.');

    }




    function findData(Request $request){

        if($request->get('find') and $request->get('find') != ''){

            $users = User::where('email','like', '%'. $request->get('find') .'%')->orWhere('name','like', '%'. $request->get('find') .'%')->get();

            $customers = Customer::where('id','like', '%'. $request->get('find') .'%')->get();

            return view('admin.customers.search', [
                'users' => $users,
                'customers' => $customers
            ]);


        }

        return 0;


    }

}