<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;

class SetLocale
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next )
	{
		$domainEndings = [
			'dk'    => 'da',
			'com'   => 'en',
			'co.uk' => 'en',
			'nl'    => 'nl',
			'.dev'    => 'da',
			'dev'    => 'nl',
		];

		$domainRedirects = [
			'eu'   => 'com',
			'net'  => 'com',
			'info' => 'com',
			'org'  => 'com',
			'com'  => 'dk',

		];

		$tld = substr( strstr( $request->getHttpHost(), '.' ), 1 );

		$locale = str_replace( '.dev', '', $tld );
		$locale = str_replace( 'takedaily.', '', $locale );

		if ( isset( $domainRedirects[ $locale ] ) )
		{
			$host       = $request->getUri();
			$redirectTo = str_replace( $locale, $domainRedirects[ $locale ], $host );

			return \Redirect::away( $redirectTo );
		}

		if ( isset( $domainEndings[ $locale ] ) )
		{
			$locale = $domainEndings[ $locale ];
		}

		if(isset($_GET['utm_source'])){
			Cookie::queue('utm_source', urlencode($_GET['utm_source']), 30);
		}

		if(isset($_GET['utm_medium'])){
			Cookie::queue('utm_medium', $_GET['utm_medium'], 30);
		}

		if(isset($_GET['utm_campaign'])){
			Cookie::queue('utm_campaign', $_GET['utm_campaign'], 30);
		}


        $locale = 'da';

		\App::setLocale( $locale );

		return $next( $request );
	}
}
