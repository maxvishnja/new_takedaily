<?php namespace App\Apricot\Helpers;

class DomainHelper
{
	public static function convertTldTo( $toTld )
	{
		$url    = \Request::fullUrl();

		$curTld = substr( strstr( \Request::getHttpHost(), '.' ), 1 );
		$curTld = str_replace( '.dev', '', $curTld );
		$curTld = str_replace( '.takedaily', '', $curTld );

		return str_replace($curTld, $toTld, $url);
	}
}