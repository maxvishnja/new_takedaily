<?php
namespace App\Apricot\Libraries;

// todo start checking if combination is possible again

use App\Combination;
use App\Vitamin;
use Illuminate\Database\Eloquent\Builder;

class CombinationLibraryNew
{
	private $groupOne;
	private $groupTwo;
	private $groupThree;

	private $vitamins    = [];
	private $advises     = [];
	private $advise_info = [];

	function __construct()
	{
	}

	public function getPillNames()
	{ // todo debug @ office
		$names = [];

		foreach ( $this->vitamins as $vitamin )
		{
			$names[] = PillLibrary::$codes[ strtolower( $vitamin ) ];
		}

		return $names;
	}

	public function getPillIds()
	{
		return array_flatten( Vitamin::whereIn( 'code', $this->vitamins )->select( 'id' )->get()->toArray() ); // todo debug @ office
	}

	public function hasOil()
	{
		return collect( $this->vitamins )->filter( function ( $vitamin )
			{
				return $vitamin == '3e' || $vitamin == '3g';
			} )->count() > 0;
	}

	function getResult()
	{
		return $this->vitamins;
	}

	function getAdvises()
	{
		return $this->advises;
	}

	function getAdviseInfos()
	{
		return $this->advise_info;
	}

	function combinationIsPossible( $groupOne, $groupTwo = null, $groupThree = null )
	{
		$combination = \Cache::remember( "combination_{$groupOne}{$groupTwo}{$groupThree}", 30, function () use ( $groupOne, $groupTwo, $groupThree )
		{
			return Combination::where( function ( Builder $query ) use ( $groupOne, $groupTwo, $groupThree )
			{
				$query->where( 'group_1', "$groupOne" );

				if ( ! is_null( $groupTwo ) )
				{
					$query->where( 'group_2', "$groupTwo" );
				}

				if ( ! is_null( $groupThree ) )
				{
					$query->where( 'group_3', "$groupThree" );
				}
				else
				{
					$query->whereNull( 'group_3' );
				}
			} )->first();
		} );

		if ( ! $combination )
		{
			if ( ! is_null( $groupThree ) )
			{
				return false;
			}
			else
			{
				return true;
			}
		}

		return $combination->isPossible();
	}

	private function setAdvise( $num = 'one', $advise )
	{
		if ( ! isset( $this->advises[ $num ] ) )
		{
			$this->advises[ $num ] = $advise;
		}
	}

	private function setAdviseInfo( $num = 'one', $advise )
	{
		if ( ! isset( $this->advise_info[ $num ] ) )
		{
			$this->advise_info[ $num ] = $advise;
		}
	}

	function generateResult( $data )
	{
		if ( ! isset( $data->gender ) && ! isset( $data->custom ) )
		{
			return [];
		}

		if ( isset( $data->locale ) && isset( $data->pregnant ) && $data->locale == 'nl' && $data->pregnant == 1 )
		{
			$this->groupOne   = 'A';
			$this->groupTwo   = 'd';
			$this->groupThree = 'e';
			$this->vitamins[] = '2A';
			$this->vitamins[] = '3d';
			$this->vitamins[] = '3e';

			$this->setAdvise( '2A', trans( 'flow.combinations.2.A' ) );
			$this->setAdviseInfo( '2A', trans( 'flow.combination_info.2.A' ) );

			$this->setAdvise( '3d', trans( 'flow.combinations.3.d' ) );
			$this->setAdviseInfo( '3d', trans( 'flow.combination_info.3.d' ) );

			$this->setAdvise( '3e', trans( 'flow.combinations.3.e' ) );
			$this->setAdviseInfo( '3e', trans( 'flow.combination_info.3.e' ) );
		}

		if ( is_null( $this->groupOne ) )
		{
			$this->generateGroupOne( $data );
		}

		if ( is_null( $this->groupTwo ) )
		{
			$this->generateGroupTwo( $data );
		}

		if ( is_null( $this->groupThree ) )
		{
			$this->generateGroupThree( $data );
		}

		if ( count( $this->vitamins ) == 0 )
		{
			$this->setAdvise( 'none', trans( 'flow.combinations.none' ) );
		}

		if ( isset( $data->replacements ) )
		{
			$newVitamins = $this->vitamins;

			foreach ( $data->replacements as $replacement )
			{
				foreach ( $this->vitamins as $index => $vitamin )
				{
					if ( $newVitamins[ $index ] == $replacement->old_vitamin )
					{
						$newVitamins[ $index ] = $replacement->new_vitamin;
					}
				}
			}

			$this->vitamins = $newVitamins;
		}

		return [];
	}

	private function generateGroupThree( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->three ) && $data->custom->three != '' && ! empty( $data->custom->three ) )
		{
			$this->vitamins[] = "3{$data->custom->three}";
			$this->groupThree = $data->custom->three;
			$this->setAdvise( "3{$data->custom->three}", trans( "flow.combinations.3.{$data->custom->three}" ) );
			$this->setAdviseInfo( "3{$data->custom->three}", trans( "flow.combination_info.3.{$data->custom->three}" ) );

			return;
		}

		if ( ( ( isset( $data->vegetarian ) && $data->vegetarian == '2' ) || ( isset( $data->foods ) && ( isset( $data->foods->fish ) && $data->foods->fish == '1' ) ) ) )
		{
			$this->vitamins[] = '3e';
			$this->groupThree = '3';

			$this->setAdvise( '3e', trans( 'flow.combinations.3.e' ) );
			$this->setAdviseInfo( '3e', trans( 'flow.combination_info.3.e' ) );

			return;
		}

		if ( isset( $data->vegetarian ) && $data->vegetarian == '1' )
		{
			$this->vitamins[] = '3d';
			$this->groupThree = 'd';

			$this->setAdvise( '3d', trans( 'flow.combinations.3.d' ) );
			$this->setAdviseInfo( '3d', trans( 'flow.combination_info.3.d' ) );

			return;
		}

		if ( isset( $data->foods ) && ( $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'a' ) && ( $data->foods->fruits == '1' || $data->foods->fruits == '2' || $data->foods->vegetables == '1' || $data->foods->vegetables == '2' ) ) )
		{
			$this->vitamins[] = '3a';
			$this->groupThree = 'a';

			$this->setAdvise( '3a', trans( 'flow.combinations.3.a' ) );
			$this->setAdviseInfo( '3a', trans( 'flow.combination_info.3.a' ) );

			return;
		}

		if ( isset( $data->gender ) && isset( $data->age ) && isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'b' ) &&
		     (
			     ( $data->foods->bread == '1' || $data->foods->wheat == '1' )
			     || ( $data->age >= '51' && $data->foods->bread < '3' )
			     || ( ( $data->gender == '2' && $data->foods->bread < '4' ) || ( $data->gender == '1' && $data->foods->bread != '4' ) )
			     || ( $data->gender == '1' && $data->age <= '70' && $data->foods->bread != '5' )
			     || ( $data->age > '50' && $data->foods->wheat != '3' )
			     || ( $data->age <= '50' && $data->foods->wheat != '4' )
		     )
		)
		{
			$this->vitamins[] = '3b';
			$this->groupThree = 'b';

			$this->setAdvise( '3b', trans( 'flow.combinations.3.b' ) );
			$this->setAdviseInfo( '3b', trans( 'flow.combination_info.3.b' ) );

			return;
		}


		if ( isset( $data->age ) && isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'c' ) && (
				( $data->foods->dairy == '1' )
				|| ( $data->age <= '50' && $data->foods->dairy < '3' )
				|| ( $data->age > '50' && $data->foods->dairy < '4' )
			)
		)
		{
			$this->vitamins[] = '3c';
			$this->groupThree = 'c';

			$this->setAdvise( '3c', trans( 'flow.combinations.3.c' ) );
			$this->setAdviseInfo( '3c', trans( 'flow.combination_info.3.c' ) );

			return;
		}
		if ( isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'f' ) && ( $data->foods->butter != '1' ) )
		{
			$this->vitamins[] = '3f';
			$this->groupThree = 'f';

			$this->setAdvise( '3f', trans( 'flow.combinations.3.f' ) );
			$this->setAdviseInfo( '3f', trans( 'flow.combination_info.3.f' ) );

			return;
		}
		if ( isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'd' ) && ( $data->foods->meat == '1' ) )
		{
			$this->vitamins[] = '3d';
			$this->groupThree = 'd';

			$this->setAdvise( '3d', trans( 'flow.combinations.3.d' ) );
			$this->setAdviseInfo( '3d', trans( 'flow.combination_info.3.d' ) );

			return;
		}

		if ( isset( $data->foods->oil ) )
		{
			if ( ( $data->foods->oil == 'fishoil' ) )
			{
				$this->vitamins[] = '3e';
				$this->groupThree = 'e';

				$this->setAdvise( '3e', trans( 'flow.combinations.3.e' ) );
				$this->setAdviseInfo( '3e', trans( 'flow.combination_info.3.e' ) );

				return;
			}

			if ( ( $data->foods->oil == 'chiaoil' ) )
			{
				$this->vitamins[] = '3g';
				$this->groupThree = 'g';

				$this->setAdvise( '3g', trans( 'flow.combinations.3.g' ) );
				$this->setAdviseInfo( '3g', trans( 'flow.combination_info.3.g' ) );

				return;
			}
		}

		if ( ( ( isset( $data->vegetarian ) && $data->vegetarian == '1' ) ) )
		{
			$this->vitamins[] = '3g';
			$this->groupThree = 'g';

			$this->setAdvise( '3g', trans( 'flow.combinations.3.g' ) );
			$this->setAdviseInfo( '3g', trans( 'flow.combination_info.3.g' ) );

			return;
		}
	}

	private function generateGroupTwo( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->two ) )
		{
			$this->groupTwo   = $data->custom->two;
			$this->vitamins[] = "2{$data->custom->two}";

			$this->setAdvise( "2{$data->custom->two}", trans( 'flow.combinations.2.A' ) );
			$this->setAdviseInfo( "2{$data->custom->two}", trans( 'flow.combination_info.2.A' ) );

			return;
		}

		// A
		if ( $this->combinationIsPossible( $this->groupOne, 'A' ) && ( isset( $data->pregnant ) && $data->pregnant == '1' ) )
		{
			$this->groupTwo   = 'A';
			$this->vitamins[] = '2A';

			$this->setAdvise( '2A', trans( 'flow.combinations.2.A' ) );
			$this->setAdviseInfo( '2A', trans( 'flow.combination_info.2.A' ) );

			return;
		}

		// B
		if ( $this->combinationIsPossible( $this->groupOne, 'B' ) && ( isset( $data->diet ) && $data->diet == '1' ) )
		{
			$this->groupTwo   = 'B';
			$this->vitamins[] = '2B';

			$this->setAdvise( '2B', trans( 'flow.combinations.2.B' ) );
			$this->setAdviseInfo( '2B', trans( 'flow.combination_info.2.B' ) );

			return;
		}

		// E
		if ( $this->combinationIsPossible( $this->groupOne, 'E' ) && ( isset( $data->joints ) && $data->joints == '1' ) )
		{
			$this->groupTwo   = 'E';
			$this->vitamins[] = '2E';

			$this->setAdvise( '2E', trans( 'flow.combinations.2.E' ) );
			$this->setAdviseInfo( '2E', trans( 'flow.combination_info.2.E' ) );

			return;
		}

		// D
		if ( $this->combinationIsPossible( $this->groupOne, 'D' ) && ( isset( $data->smokes ) && $data->smokes == '1' ) )
		{
			$this->groupTwo   = 'D';
			$this->vitamins[] = '2D';

			$this->setAdvise( '2D', trans( 'flow.combinations.2.D' ) );
			$this->setAdviseInfo( '2D', trans( 'flow.combination_info.2.D' ) );

			return;
		}

		// C
		if ( $this->combinationIsPossible( $this->groupOne, 'C' ) && ( isset( $data->sports ) && $data->sports == '4' ) )
		{
			$this->groupTwo   = 'C';
			$this->vitamins[] = '2C';

			$this->setAdvise( '2C', trans( 'flow.combinations.2.C' ) );
			$this->setAdviseInfo( '2C', trans( 'flow.combination_info.2.C' ) );

			return;
		}

		// D
		if ( $this->combinationIsPossible( $this->groupOne, 'D' ) && ( isset( $data->immune_system ) && $data->immune_system != '1' ) )
		{
			$this->groupTwo   = 'D';
			$this->vitamins[] = '2D';

			$this->setAdvise( '2D', trans( 'flow.combinations.2.D' ) );
			$this->setAdviseInfo( '2D', trans( 'flow.combination_info.2.D' ) );

			return;
		}

		// C
		if ( $this->combinationIsPossible( $this->groupOne, 'C' ) && ( ( isset( $data->stressed ) && $data->stressed == '1' ) || ( isset( $data->lacks_energy ) && $data->lacks_energy < '3' ) ) )
		{
			$this->groupTwo   = 'C';
			$this->vitamins[] = '2C';

			$this->setAdvise( '2C', trans( 'flow.combinations.2.C' ) );
			$this->setAdviseInfo( '2C', trans( 'flow.combination_info.2.C' ) );

			return;
		}
	}

	private function generateGroupOne( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->one ) )
		{
			$this->groupOne   = $data->custom->one;
			$this->vitamins[] = "1{$data->custom->one}";

			$this->setAdvise( "1{$data->custom->one}", trans( 'flow.combinations.1.basic' ) );
			$this->setAdviseInfo( "1{$data->custom->one}", trans( 'flow.combination_info.1.basic' ) );

			return;
		}

		if ( isset( $data->gender ) && $data->gender == '1' )
		{
			// Males
			if ( $data->age < '70' )
			{
				// Below 70 of age
				if ( $data->skin == '1' )
				{
					// White skin
					if ( $data->outside == '1' )
					{
						// Outside
						$this->groupOne   = '1';
						$this->vitamins[] = "1a";

						$this->setAdvise( '1a', trans( 'flow.combinations.1.basic' ) );
						$this->setAdviseInfo( '1a', trans( 'flow.combination_info.1.basic' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne   = '2';
						$this->vitamins[] = "1b";

						$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d-alt' ) );
						$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

						return;
					}
				}
				else
				{
					// Dark / med skin
					if ( $data->outside == '1' )
					{
						// Outside
						$this->groupOne   = '2';
						$this->vitamins[] = "1b";

						$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d' ) );
						$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne   = '2';
						$this->vitamins[] = "1b";

						$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d-alt' ) );
						$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

						return;
					}
				}
			}
			elseif ( $data->age >= '70' )
			{
				// Above 70 of age
				if ( $data->skin == '1' )
				{
					// White skin
					if ( $data->outside == '1' )
					{
						// Outside
						$this->groupOne   = '3';
						$this->vitamins[] = "1c";

						$this->setAdvise( '1c', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne   = '3';
						$this->vitamins[] = "1c";

						$this->setAdvise( '1c', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

						return;
					}
				}
				else
				{
					// Dark / med skin
					if ( $data->outside == '1' )
					{
						// Outside
						$this->groupOne   = '3';
						$this->vitamins[] = "1c";

						$this->setAdvise( '1c', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne   = '3';
						$this->vitamins[] = "1c";

						$this->setAdvise( '1c', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

						return;
					}
				}
			}
		}
		elseif ( isset( $data->gender ) && $data->gender == '2' )
		{
			// Females
			if ( isset( $data->pregnant ) && $data->pregnant == 1 )
			{
				// Pregnant
				$this->groupOne   = '1';
				$this->vitamins[] = "1a";

				$this->setAdvise( '1a', trans( 'flow.combinations.1.basic' ) );
				$this->setAdviseInfo( '1a', trans( 'flow.combination_info.1.basic' ) );

				return;
			}
			else
			{
				// Not pregnant
				if ( isset( $data->age ) && $data->age < '50' )
				{
					// Below 50 of age
					if ( $data->skin == '1' )
					{
						// White skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne   = '1';
							$this->vitamins[] = "1a";

							$this->setAdvise( '1a', trans( 'flow.combinations.1.basic' ) );
							$this->setAdviseInfo( '1a', trans( 'flow.combination_info.1.basic' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

							return;
						}
					}
					else
					{
						// Dark / med skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne   = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d' ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

							return;
						}
					}
				}
				elseif ( isset( $data->age ) && $data->age >= '50' && $data->age < '70' )
				{
					// Between 50-70 of age
					if ( $data->skin == '1' )
					{
						// White skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne   = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d' ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

							return;
						}
					}
					else
					{
						// Dark / med skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne   = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d' ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( '1b', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

							return;
						}
					}
				}
				elseif ( isset( $data->age ) && $data->age >= '70' )
				{
					// Above 70 of age
					if ( $data->skin == '1' )
					{
						// White skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne   = '3';
							$this->vitamins[] = "1c";

							$this->setAdvise( '1c', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '3';
							$this->vitamins[] = "1c";

							$this->setAdvise( '1c', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
					}
					else
					{
						// Dark / med skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne   = '3';
							$this->vitamins[] = "1c";

							$this->setAdvise( '1c', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '3';
							$this->vitamins[] = "1c";

							$this->setAdvise( '1c', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
					}
				}
			}
		}
	}
}