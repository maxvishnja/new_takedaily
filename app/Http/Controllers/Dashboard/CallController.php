<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\CallRepository;
use App\Call;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class CallController extends Controller
{

	private $repo;

	function __construct(CallRepository $repo)
	{
		$this->repo = $repo;
	}

	function index()
	{
		$calls = $this->repo->all();

		return view('admin.calls.home', [
			'calls' => $calls
		]);
	}

	function markDone($id)
	{
		$call = Call::find($id);

		if ( !$call )
		{
			return \Redirect::back()->withErrors("Opkaldet (#{$id}) kunne ikke findes!");
		}

		$call->status = 'done';
		$call->save();

		return \Redirect::action('Dashboard\CallController@index')->with('success', 'Opkaldet er blevet markeret som færdigt!');
	}
}
