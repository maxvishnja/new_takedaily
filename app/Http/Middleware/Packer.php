<?php

namespace App\Http\Middleware;

use Closure;

class Packer
{

	protected $except = [
		'packer/login',
	];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
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
			    return redirect()->guest('dashboard/login');
		    }
	    }

	    if ( \Auth::user() && !\Auth::user()->isPacker() )
	    {
		    return response('Page not found.', 404);
	    }
        return $next($request);
    }
}
