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
			'dk'  => 'da',
			'com' => 'en'
		];

		$placeholder = 'XXXXXXXXXX';

		$tldRegex = preg_quote( str_replace( '{locale}', $placeholder, env( 'DOMAIN_FORMAT' ) ) );

		$tldRegex = str_replace( $placeholder, '([a-z\-]{2,6})', $tldRegex );

		preg_match( "/$tldRegex/", $request->getHost(), $matches );

		if ( count( $matches ) > 0 )
		{
			$locale = $matches[1];

			if ( isset( $domainEndings[ $locale ] ) )
			{
				$locale = $domainEndings[ $locale ];
			}

			\App::setLocale($locale);
		}

		return $next( $request );
	}
}
