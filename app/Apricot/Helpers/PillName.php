<?php


namespace App\Apricot\Helpers;


class PillName
{
	public static function get($vitamin)
	{
		$vitamin = strtolower($vitamin);

		return trans("pill-names.{$vitamin}");
	}
}