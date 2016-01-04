<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
	/**
	 * The URIs that should be excluded from the middleware
	 *
	 * @var array
	 */
	protected $except = [
		'dashboard/login',
	];
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
		foreach ($this->except as $except) {
			if ($except !== '/') {
				$except = trim($except, '/');
			}

			if ($request->is($except)) {
				return $next($request);
			}
		}

		if ( Auth::guard($guard)->guest() )
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

		if ( Auth::user() && !Auth::user()->isAdmin() )
		{
			return response('Page not found.', 404);
		}

		return $next($request);
	}
}
