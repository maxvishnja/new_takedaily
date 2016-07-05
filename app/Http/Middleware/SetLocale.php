<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Date\Date;

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
	 * @param  \Illuminate\Http\Request $re quest
	 * @param  \Closure                 $next
	 * @param  string|null              $guard
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		$locale = \Session::get('locale', env('DEFAULT_LOCALE', 'da'));
		
		\App::setLocale($locale);
		Date::setLocale($locale);
		\Mail::alwaysFrom(trans('general.mail'));
		\Config::set('currency', trans('general.currency'));

		return $next($request);
	}
}
