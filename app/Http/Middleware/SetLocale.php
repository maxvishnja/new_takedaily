<?php

namespace App\Http\Middleware;

use Closure;

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
		];

		$domainRedirects = [
			'eu'   => 'com',
			'net'  => 'com',
			'info' => 'com',
			'org'  => 'com',
		];

		$tld = substr( strstr( $request->getHttpHost(), '.' ), 1 );

		$locale = str_replace( '.dev', '', $tld );

		if ( isset( $domainRedirects[ $locale ] ) )
		{
			$host = $request->getUri();
			$redirectTo = str_replace($locale, $domainRedirects[ $locale ], $host);

			return \Redirect::away($redirectTo);
		}

		if ( isset( $domainEndings[ $locale ] ) )
		{
			$locale = $domainEndings[ $locale ];
		}

		\App::setLocale( $locale );

		return $next( $request );
	}
}
