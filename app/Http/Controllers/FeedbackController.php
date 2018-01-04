<?php
namespace App\Http\Controllers;


use App\Customer;
use App\Feedback;
use App\Plan;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function index($id = 0)
    {

        $customer = Customer::find($id);
        if ($id == 0) {
            $name = 'Guest';
        } else {
            $name = $customer->getName();
        }

        return view('feedback.main', ['customer_id' => $id, 'name' => $name]);


    }


    public function addFeedback(Request $request)
    {

        if (\Request::ajax()) {
            $data = $request->all();
            $feedback = new Feedback();
            $feedback->title = $request->get('title');
            $feedback->text = $request->get('text');
            $feedback->customer_id = $request->get('customer_id');

            $feedback->save();
            if ($feedback->customer_id != 0) {
                $customer = Customer::find($feedback->customer_id);
                $mailName = 'TakeDaily';
                $locale = \App::getLocale();

                if ($locale == 'nl') {
                    $fromEmail = 'info@takedaily.nl';
                    $mailEmail = 'info@takedaily.nl';
                } else {
                    $fromEmail = 'info@takedaily.dk';
                    $mailEmail = 'info@takedaily.dk';
                }

                \Mail::queue('emails.feedback', ['name' => $customer->getName()], function ($message) use ($mailEmail, $mailName, $locale, $fromEmail) {
                    \App::setLocale($locale);
                    $message->from($fromEmail, 'TakeDaily');
                    $message->to($mailEmail, $mailName);
                    $message->subject(trans('mails.feedback.subject'));
                });
            }

            return 'Ok';
        } else {
            return 'error';
        }
    }

}