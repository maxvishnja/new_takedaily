<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\CouponRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
	private $repo;

	function __construct(CouponRepository $repository)
	{
		$this->repo = $repository;
	}

	function index()
	{
		return view('admin.coupons.home', [
			'coupons' => $this->repo->all()
		]);
	}
}
