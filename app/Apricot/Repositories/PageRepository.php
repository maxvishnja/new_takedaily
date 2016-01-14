<?php namespace App\Apricot\Repositories;

use App\Page;

class PageRepository
{

	public function all()
	{
		return Page::all();
	}
	
}