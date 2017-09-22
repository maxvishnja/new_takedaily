<?php

namespace App\Http\Middleware;

use Closure;

class Packer
{

	protected $except = [
		'packaging/login',
	];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  $guard  string|null
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
	    foreach ($this->except as $except) {
		    if ($except !== '/') {
			    $except = trim($except, '/');
		    }

		    if ($request->is($except)) {
			    return $next($request);
		    }
	    }

	    if ( \Auth::guard($guard)->guest() )
	    {
		    if ( $request->ajax() )
		    {
			    return response('Unauthorized.', 401);
		    }
		    else
		    {
			    return redirect()->guest('packaging/login');
		    }
	    }

	    if ( \Auth::user() && !(\Auth::user()->isPacker() || \Auth::user()->isAdmin()) )
	    {
		    return response('Page not found.', 404);
	    }
        return $next($request);
    }
}
