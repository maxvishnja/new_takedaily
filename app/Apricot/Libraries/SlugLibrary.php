<?php namespace App\Apricot\Libraries;


class SlugLibrary
{
	public static function generate($title = '')
	{
		$title = str_slug($title);
		$title = str_limit($title, 50, '');

		return $title;
	}
}