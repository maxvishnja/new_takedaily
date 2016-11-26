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
					[ 'email' => $request->get( 'email' ) ],
					null,
					'html',
					false
				);
		} catch ( \Mailchimp_List_AlreadySubscribed $e )
		{
			return \Response::json( [ 'errors' => trans('mailchimp.already-subscribed') ], 422 );
		} catch ( \Mailchimp_Error $e )
		{
			return \Response::json( [ 'errors' => trans('mailchimp.unknown') ], 422 );
		}

		return \Response::json( [ 'Ok' ] );
	}
}
