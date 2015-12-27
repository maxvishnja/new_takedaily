<?php namespace App\Apricot\Repositories;

class PageRepository
{

	public function generateIdentifier($title)
	{
		$identifier = $title;

		return substr($identifier, 0, 50);
	}
	
}