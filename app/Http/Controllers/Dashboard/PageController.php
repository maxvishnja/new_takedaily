<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\PageRepository;
use App\Page;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
	/*
	 * @var \App\Apricot\Repositories\PageRepository
	 */
	private $repo;

    function __construct(PageRepository $repo)
	{
		$this->repo = $repo;
	}

	function index()
	{
		return view('admin.cms.home', [
			'pages' => $this->repo->all()
		]);
	}

	function edit($id)
	{
		echo $id;
	}

	function create()
	{
		return view('admin.cms.create');
	}

	function store(Request $request)
	{
		$page = new Page();
		dd($page->generateIdentifier($request->get('title')));
	}

	function destroy($id)
	{
		echo $id;
	}

}
