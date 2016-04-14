<?php namespace App\Apricot\Libraries;


use App\Apricot\Repositories\TaxZoneRepository;

class TaxLibrary
{
	private $zone;

	function __construct($zone)
	{
		$repository = new TaxZoneRepository();

		$this->zone = $repository->getZone($zone);
	}

	public function zone()
	{
		return $this->zone;
	}

	public function rate()
	{
		return $this->zone->rate / 100 * 0.8; // todo validate that * 0.8 simply works..
	}

	public function reversedRate()
	{
		return 1 - (($this->zone->rate / 100) * 0.8); // todo validate that * 0.8 simply works..
	}
}