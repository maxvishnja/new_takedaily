<?php

namespace App\Http\Controllers;

use App\Apricot\Helpers\EmailPlatformApi;
use Illuminate\Http\Request;

use App\Http\Requests;

class MailchimpEmailSignup extends Controller
{
	/**
	 * @var \Mailchimp
	 */
	private $mailchimp;

	function __construct( \Mailchimp $mailchimp )
	{
		$this->mailchimp = $mailchimp;
	}

	function post( Request $request )
	{
		$this->validate( $request, [
			'email' => 'email|required'
		] );


        $listid = 5465;

        $add_to_autoresponders = false;
        $skip_listcheck = true;

        $parser = new EmailPlatformApi();


        $emailaddress = $request->get( 'email' );
        $mobile = '';
        $mobilePrefix = '';



        if(\App::getLocale() == "nl")
        {
            $country = 'NLD';
        }      else{
            $country = 'DNK';
        }



        $customfields  =  array (
            array (
                'fieldid'  => 11,
                'value'  =>  $country),
        );

        $result = $parser->AddSubscriberToList($listid, $emailaddress, $mobile, $mobilePrefix, $customfields, $add_to_autoresponders, $skip_listcheck);



        //$listId = trans( 'general.mailchimp_list_id' );


	if($result == 'Already subscribed to the list.'){
        return \Response::json( [ 'errors' => trans('mailchimp.unknown') ], 422 );
    } else{
        return \Response::json( [ 'Ok' ] );
    }

	}
}
