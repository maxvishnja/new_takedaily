<?php namespace App\Apricot\Helpers;

class NavGenerator
{
	private static function getSubnav( $identifier, $locale )
	{
		$subnav = [];
		if ( is_array( trans( "nav.subitems.{$identifier}" ) ) )
		{
			foreach ( trans( "nav.subitems.{$identifier}" ) as $subGroupKey => $subGroupItems )
			{
				foreach ( $subGroupItems as $subnavIdentifier )
				{
					if ( $page = \App\Page::whereUrlIdentifier( $subnavIdentifier )->first() )
					{
						$translation = $page->translations()
						                    ->whereLocale( $locale )
						                    ->first();

						if ( $translation )
						{
							$page->title = $translation->title;
						}

						$link = 'page/' . $page->url_identifier;
						$text = $page->title;

						$subnav[ $subGroupKey ][] = [
							'link' => $link,
							'text' => $text
						];
					}
				}

				if ( isset( $subnav[ $subGroupKey ] ) )
				{
					$subnav[ $subGroupKey ] = collect( $subnav[ $subGroupKey ] )->sortBy( 'text', SORT_NATURAL )->toArray();
				}
			}
		}

		return $subnav;
	}

	public static function generate( $locale )
	{
		return \Cache::remember( "nav.{$locale}", 60, function () use ( $locale )
		{
			$nav      = \App\Nav::all();
			$navArray = [];

			foreach ( $nav as $navItem )
			{
				$link = $navItem->path;
				$text = trans( strtolower( "nav.items.{$navItem->title}" ) );

				if ( $page = \App\Page::whereUrlIdentifier( $link )->first() )
				{
					$translation = $page->translations()
					                    ->whereLocale( $locale )
					                    ->first();

					if ( $translation )
					{
						$page->title = $translation->title;
					}

					$link = 'page/' . $page->url_identifier;
					$text = $page->title;
				}

				$navArray[] = [
					'text'     => $text,
					'link'     => $link,
					'subitems' => self::getSubnav( strtolower( $navItem->title ), $locale )
				];
			}

			return $navArray;
		} );
	}
}