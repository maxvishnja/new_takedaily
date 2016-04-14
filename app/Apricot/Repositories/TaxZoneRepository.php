<?php namespace App\Apricot\Repositories;


use App\TaxZone;

class TaxZoneRepository
{
	public function getZone($name)
	{
		return TaxZone::where('name', $name)->firstOrFail();
	}
}