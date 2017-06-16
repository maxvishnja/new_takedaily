<?php namespace App\Apricot\Libraries;


use App\Apricot\Repositories\TaxZoneRepository;

class TaxLibrary
{
	private $zone;

	function __construct( $zone )
	{
		$repository = new TaxZoneRepository();

		$this->zone = $repository->getZone( $this->formatZone( $zone ) );
	}

	private function formatZone( $zone )
	{
		switch ( strtolower($zone) )
		{
			case 'danmark':
			case 'dansk':
			case 'dk':
			case '':
				return 'denmark';

			case 'nederland':
			case 'nederlands':
			case 'dutch':
			case 'nl':
				return 'netherlands';


//			case 'belgium':
//				return 'belgium';

			default:
				return $zone;
		}
	}

	public function zone()
	{
		return $this->zone;
	}

	public function rate()
	{
		return ( $this->zone->rate / ( 100 + $this->zone->rate ) );
//		return $this->zone->rate / 100 * 0.8;
	}

	public function reversedRate()
	{
		return 1 - ( ( $this->zone->rate / 100 ) * 0.8 );
	}

	public function getSubtotal( $amount )
	{
		return $amount / ( 1 + ( $this->zone()->rate / 100 ) );
	}

	public function getTaxes( $amount )
	{
		return $amount - ( $amount / ( 1 + ( $this->zone()->rate / 100 ) ) );
	}

	public function convertSubtotalToTotal( $subtotal )
	{
		return $subtotal * ( 1 + ( $this->zone()->rate / 100 ) );
	}
}