<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\RewriteRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\UrlRewrite;

class RewriteController extends Controller
{

	private $repo;

	function __construct(RewriteRepository $repo)
	{
		$this->repo = $repo;
	}

	function index()
	{
		$rewrites = $this->repo->all();

		return view('admin.rewrites.home', [
			'rewrites' => $rewrites
		]);
	}

	function remove($id)
	{
		UrlRewrite::find($id)->delete();

		\Cache::tags('url_rewrites')->flush();

		return \Redirect::back()->with('success', 'Omdirigeringen blev slettet!');
	}
}
