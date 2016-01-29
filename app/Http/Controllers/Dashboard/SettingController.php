<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\SettingsRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

	private $repo;

	/**
	 * SettingController constructor.
	 *
	 * @param $repo
	 */
	public function __construct(SettingsRepository $repo)
	{
		$this->repo = $repo;
	}

	function index()
	{
		return view('admin.settings.home', [
			'settings' => $this->repo->all()
		]);
	}

	function update($id, Request $request)
	{

	}
}
