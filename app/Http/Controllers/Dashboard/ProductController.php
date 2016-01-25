<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\ProductRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
	private $repo;

	function __construct(ProductRepository $repository)
	{
		$this->repo = $repository;
	}

	function index()
	{
		return view('admin.products.home', [
			'products' => $this->repo->all()
		]);
	}

	function show($id)
	{

	}

	function edit($id)
	{

	}

	function create()
	{

	}

	function store()
	{

	}

	function update($id)
	{

	}

	function destroy($id)
	{

	}
}
