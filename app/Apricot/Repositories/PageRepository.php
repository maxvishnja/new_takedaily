<?php namespace App\Apricot\Repositories;

use App\Page;

class PageRepository
{

	public function all()
	{
		return Page::orderBy('created_at', 'DESC')->get();
	}

	public function findByIdentifier($identifier)
	{
		return Page::where('url_identifier', $identifier)->get();
	}
	
}