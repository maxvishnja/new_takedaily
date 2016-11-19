<?php

namespace App\Jobs;

use App\Customer;
use App\Giftcard;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GiftcardWasOrdered extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
	/**
	 * @var Giftcard
	 */
	private $giftcard;
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * GiftcardWasOrdered constructor.
	 *
	 * @param Giftcard $giftcard
	 * @param Customer $customer
	 */
    public function __construct(Giftcard $giftcard, Customer $customer)
    {
        //
	    $this->giftcard = $giftcard;
	    $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	\App::setLocale($this->customer->getLocale());

        $pdf = $this->giftcard->outputPdf($this->customer);

        $to = $this->customer->getEmail();
        $name = $this->customer->getName();

        \Mail::send('emails.giftcard', [], function(Message $message) use($pdf, $to, $name)
        {
        	$message->to($to, $name);
        	$message->subject(trans('mails.giftcard.subject'));
        	$message->attachData($pdf, 'giftcard.pdf', [
        		'mime' => 'application/pdf'
	        ]);
        });
    }
}
