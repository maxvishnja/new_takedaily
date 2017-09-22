<?php namespace App\Apricot\Repositories;

use App\Setting;

class SettingsRepository
{
	public function all()
	{
		return Setting::orderBy('created_at', 'DESC')->get();
	}
}