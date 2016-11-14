<?php namespace App\Apricot\Repositories;

use App\Faq;

class FaqRepository
{

	public function all()
	{
		return Faq::orderBy('created_at', 'DESC')->get();
	}

	public function get()
	{
		$faqs = Faq::with( [
			'translations' => function ( $query )
			{
				$query->where( 'locale', \App::getLocale() )->limit(1);
			}
		] )->get();

		$faqArray = [];

		foreach ( $faqs as $faq )
		{
			if ( $faq->translations->count() > 0 )
			{
				$faq->identifier = $faq->translations->first()->identifier;
				$faq->question = $faq->translations->first()->question;
				$faq->answer = $faq->translations->first()->answer;
			}

			unset($faq->translations);
			unset($faq->updated_at);
			unset($faq->created_at);
			unset($faq->id);

			$faqArray[] = $faq;
		}

		return collect($faqArray);
	}

	public function create( $title, $body, $translations = [] )
	{
		$faq = Faq::create( [
			'identifier' => str_slug( str_limit( $title, 60, '' ) ),
			'question'   => $title,
			'answer'     => $body
		] );

		foreach ( $translations as $translation )
		{
			$faq->translations()->create( [
				'locale'     => $translation['locale'],
				'identifier' => str_slug( str_limit( $translation['question'], 60, '' ) ),
				'question'   => $translation['question'],
				'answer'     => $translation['answer'],
			] );
		}

		return $faq;
	}
}