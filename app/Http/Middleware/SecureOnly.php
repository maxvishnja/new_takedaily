<?php

namespace App\Http\Middleware;

use Closure;

class SecureOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if( !$request->isSecure() && \App::environment() == 'production' )
		{
			if ( $request->ajax() )
			{
				return response('HTTPS Required.', 403);
			}
			else
			{
				return redirect()->secure($request->path());
			}
		}

        return $next($request);
    }
}
