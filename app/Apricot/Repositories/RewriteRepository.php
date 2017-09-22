<?php namespace App\Apricot\Repositories;


use App\UrlRewrite;

class RewriteRepository
{
	public function all()
	{
		return UrlRewrite::orderBy('created_at', 'DESC')->get();
	}
}