<?php namespace App\Apricot\Repositories;


use App\Call;

class CallRepository
{
	public function all()
	{
		return Call::orderByRaw("CASE `status` WHEN 'requested' THEN 1 ELSE 2 END ASC")->orderBy('created_at', 'DESC')->get();
	}

	public function getRequests()
	{
		return Call::where('status', 'requested');
	}
}