<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\FaqRepository;
use App\Faq;
use App\Http\Controllers\Controller;
use App\UrlRewrite;
use Illuminate\Http\Request;

class FaqController extends Controller
{
	/*
	 * @var \App\Apricot\Repositories\FaqRepository
	 */
	private $repo;

	function __construct( FaqRepository $repo )
	{
		$this->repo = $repo;
	}

	function index()
	{
		return view( 'admin.faq.home', [
			'faqs' => $this->repo->all()
		] );
	}

	function edit( $id )
	{
		$faq = Faq::find( $id );

		if ( ! $faq )
		{
			return \Redirect::back()->withErrors( "Not found!" );
		}

		return view( 'admin.faq.manage', [
			'faq' => $faq
		] );
	}

	function update( Request $request, $id )
	{
		$faq = Faq::find( $id );

		if ( ! $faq )
		{
			return \Redirect::back()->withErrors( "Not found!" );
		}

		$oldIdentifier = $faq->identifier;

		$faq->identifier = str_slug( str_limit($request->get( 'question' ), 60, ''));
		$faq->answer     = $request->get( 'answer' );
		$faq->question   = $request->get( 'question' );

		$faq->save();

		if( $oldIdentifier !== $faq->identifier)
		{
			UrlRewrite::create([
				'requested_path' => '/faq/' . $oldIdentifier,
				'actual_path'    => '/faq/' . $faq->identifier
			]);

			\Cache::tags('url_rewrites')->flush();
		}


		return \Redirect::action( 'Dashboard\FaqController@index' )->with( 'success', 'Saved!' );
	}

	function create()
	{
		return view( 'admin.faq.manage' );
	}

	function store( Request $request )
	{
		$faq             = new Faq();

		$faq->identifier = str_slug( str_limit($request->get( 'question' ), 60, ''));
		$faq->answer     = $request->get( 'answer' );
		$faq->question   = $request->get( 'question' );

		$faq->save();

		return \Redirect::action( 'Dashboard\FaqController@index' )->with( 'success', 'Updated!' );
	}

	function destroy( $id )
	{
		$faq = Faq::find( $id );

		if ( ! $faq )
		{
			return \Redirect::back()->withErrors( "Not found!" );
		}

		$faq->delete();

		return \Redirect::action( 'Dashboard\FaqController@index' )->with( 'success', 'Deleted' );
	}

}
