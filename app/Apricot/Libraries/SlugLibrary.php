<?php namespace App\Apricot\Libraries;


class SlugLibrary
{
	public static function generate($title = '')
	{
		$title = trim($title, ' ');
		$title = strtolower($title);
		$title = preg_replace("/(å)/", 'aa', $title);
		$title = preg_replace("/(ø)/", 'oe', $title);
		$title = preg_replace("/(æ)/", 'ae', $title);
		$title = preg_replace("/\s\s+/", ' ', $title);
		$title = preg_replace("/( )/", '-', $title);
		$title = preg_replace("/([^a-z0-9-])/", '', $title);
		$title = preg_replace("/\-\-+/", '-', $title);
		$title = substr($title, 0, 50);

		return $title;
	}
}