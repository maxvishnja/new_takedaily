<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		'/dashboard/upload/image',
		'/checkout/mollie',
		'/cart-pick-n-mix',
		'/save-state',
		'/flow/recommendations',
		'/checkout/apply-coupon',
		'/pick-n-mix',
		'/flow'
	];
}
