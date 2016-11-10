<?php namespace App\Apricot\Helpers;

class NavGenerator
{
	public static function generate($locale)
	{
		return \Cache::remember("nav.{$locale}", 60, function () use($locale)
		{
			$nav = \App\Nav::all();
			$navArray = [];

			foreach ( $nav as $navItem )
			{
				$link = $navItem->path;
				$text = trans("nav.items.{$navItem->title}");


				if ( $page = \App\Page::whereUrlIdentifier( $link )->first() )
				{
					$translation = $page->translations()
					                    ->whereLocale( $locale )
					                    ->first();

					if ( $translation )
					{
						$page->title = $translation->title;
					}

					$text = $page->title;
				}

				$navArray[$link] = $text;
			}

			return $navArray;
		});
	}
}