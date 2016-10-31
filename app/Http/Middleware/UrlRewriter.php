<?php

namespace App\Http\Middleware;

use App\UrlRewrite;
use Closure;

class UrlRewriter
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$rewrite = \Cache::tags('url_rewrites')->remember(\URL::getRequest()->getPathInfo(), 30, function ()
		{
			return UrlRewrite::where('requested_path', \URL::getRequest()->getPathInfo())->select(['actual_path', 'redirect_type'])->limit(1)->get();
		});

		if ( $rewrite = $rewrite->first() )
		{
			return redirect()->to($rewrite->actual_path, $rewrite->redirect_type)->send();
		}

		return $next($request);
	}
}
