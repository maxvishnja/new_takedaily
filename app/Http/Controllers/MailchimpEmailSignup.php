<?php

namespace App\Http\Controllers;

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

		$listId = trans( 'general.mailchimp_list_id' );

		try
		{
			$this->mailchimp
				->lists
				->subscribe(
					$listId,
					[ 'email' => $request->get( 'email' ) ]
				);
		} catch ( \Mailchimp_List_AlreadySubscribed $e )
		{
			return \Response::json( [ 'errors' => 'Already subscribed' ], 422 ); // todo translate
		} catch ( \Mailchimp_Error $e )
		{
			return \Response::json( [ 'errors' => 'Unknown error' ], 422 ); // todo translate
		}

		return \Response::json( [ 'Ok' ] );
	}
}
