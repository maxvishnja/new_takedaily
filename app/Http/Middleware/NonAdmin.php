<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NonAdmin
{
	/**
	 * The URIs that should be excluded from the middleware
	 *
	 * @var array
	 */
	protected $except = [];
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @param  string|null              $guard
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if ( Auth::user() && Auth::user()->isAdmin() )
		{
			if ( $request->ajax() )
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('dashboard')->withErrors('You\'re an admin. Please log out to use the desired feature.');
			}
		}

		return $next($request);
	}
}
