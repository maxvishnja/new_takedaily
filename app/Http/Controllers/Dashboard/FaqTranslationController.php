<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Faq;
use App\FaqTranslation;
use App\UrlRewrite;
use Illuminate\Http\Request;

class FaqTranslationController extends Controller
{

	function edit( $id )
	{
		$translation = FaqTranslation::find( $id );

		if ( ! $translation )
		{
			return \Redirect::back()->withErrors( "Not found!" );
		}

		return view( 'admin.faq_translations.manage', [
			'translation' => $translation,
			'faq'         => $translation->faq
		] );
	}

	function update( Request $request, $id )
	{
		$translation = FaqTranslation::find( $id );

		if ( ! $translation )
		{
			return \Redirect::back()->withErrors( "Not found!" );
		}

		$oldIdentifier = $translation->identifier;

		$translation->locale     = $request->get( 'locale' );
		$translation->question   = $request->get( 'question' );
		$translation->answer     = $request->get( 'answer' );
		$translation->identifier = str_slug( str_limit( $request->get( 'question' ), 60, '' ) );

		$translation->save();

		if( $oldIdentifier !== $translation->identifier)
		{
			UrlRewrite::create([
				'requested_path' => '/faq/' . $oldIdentifier,
				'actual_path'    => '/faq/' . $translation->identifier
			]);

			\Cache::tags('url_rewrites')->flush();
		}

		return \Redirect::action( 'Dashboard\FaqController@edit', [ 'id' => $translation->faq_id ] )->with( 'success', 'Saved!' );
	}

	function create( Request $request )
	{
		$faqId = $request->get( 'faq' );

		if ( ! $faqId )
		{
			return \Redirect::back()->withErrors( "Not found!" );
		}

		$faq = Faq::find( $faqId );

		if ( ! $faq )
		{
			return \Redirect::back()->withErrors( "Not found!" );
		}

		return view( 'admin.faq_translations.manage', [
			'faq' => $faq
		] );
	}

	function store( Request $request )
	{
		$translation = new FaqTranslation();

		$translation->locale     = $request->get( 'locale' );
		$translation->faq_id     = $request->get( 'faq_id' );
		$translation->question   = $request->get( 'question' );
		$translation->answer     = $request->get( 'answer' );
		$translation->identifier = str_slug( str_limit( $request->get( 'question' ), 60, '' ) );

		$translation->save();

		return \Redirect::action( 'Dashboard\FaqController@edit', [ 'id' => $translation->faq_id ] )->with( 'success', 'Saved!' );
	}

	function delete( $id )
	{
		$translation = FaqTranslation::find( $id );

		if ( ! $translation )
		{
			return \Redirect::back()->withErrors( "Not found!" );
		}

		$faqId = $translation->faq_id;

		$translation->delete();

		return \Redirect::action( 'Dashboard\FaqController@edit', [ 'id' => $faqId ] )->with( 'success', 'Deleted!' );
	}

}
