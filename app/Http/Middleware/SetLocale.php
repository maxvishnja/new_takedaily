<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
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
	 * @param  \Illuminate\Http\Request $re	quest
	 * @param  \Closure                 $next
	 * @param  string|null              $guard
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		\App::setLocale(\Session::get('locale', env('DEFAULT_LOCALE', 'da')));

		return $next($request);
	}
}
