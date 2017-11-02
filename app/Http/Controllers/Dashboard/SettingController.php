<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Helpers\EmailPlatformApi;
use App\Apricot\Repositories\SettingsRepository;
use App\Setting;
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

        $connect = new EmailPlatformApi();

        dd($connect->TestUserToken());



		return view('admin.settings.home', [
			'settings' => $this->repo->all()
		]);
	}

	function update($id, Request $request)
	{
		$setting = Setting::find($id);

		if( ! $setting )
		{
			return \Redirect::back()->withErrors("Setting not found!");
		}

		$data = $request->all();

		$setting->update($data);

		return \Redirect::action('Dashboard\SettingController@index')->with('success', 'Settings blev opdateret!');
	}
}
