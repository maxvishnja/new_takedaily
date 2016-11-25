<?php
namespace App\Apricot\Libraries;

// todo start checking if combination is possible again

use App\Combination;
use App\Vitamin;
use Illuminate\Database\Query\Builder;

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

		foreach($this->vitamins as $vitamin)
		{
			$names[] = PillLibrary::$codes[$vitamin];
		}

		return $names;
	}

	public function getPillIds()
	{
		return array_flatten(Vitamin::whereIn('code', $this->vitamins)->select('id')->get()->toArray()); // todo debug @ office
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

		$this->generateGroupOne( $data );
		$this->generateGroupTwo( $data );
		$this->generateGroupThree( $data );

		if ( count( $this->vitamins ) == 0 )
		{
			$this->setAdvise( 'none', trans( 'flow.combinations.none' ) );
		}

		return [];
	}

	private function generateGroupThree( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->three ) && $data->custom->three != '' && ! empty( $data->custom->three ) )
		{
			$this->vitamins[] = "3{$data->custom->three}";
			$this->groupThree = $data->custom->three;
			$this->setAdvise( 'three', trans( "flow.combinations.3.{$data->custom->three}" ) );
			$this->setAdviseInfo( 'three', trans( "flow.combination_info.3.{$data->custom->three}" ) );

			return;
		}

		if ( ( ( isset( $data->vegetarian ) && $data->vegetarian == '2' ) || ( isset( $data->foods ) && ( isset( $data->foods->fish ) && $data->foods->fish == '1' ) ) ) )
		{
			$this->vitamins[] = '3e';
			$this->groupThree = '3';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.e' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.e' ) );

			return;
		}

		if ( isset( $data->vegetarian ) && $data->vegetarian == '1' )
		{
			$this->vitamins[] = '3d';
			$this->groupThree = 'd';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.d' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.d' ) );

			return;
		}

		if ( isset( $data->foods ) && ( $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'a' ) && ( $data->foods->fruits == '1' || $data->foods->fruits == '2' || $data->foods->vegetables == '1' || $data->foods->vegetables == '2' ) ) )
		{
			$this->vitamins[] = '3a';
			$this->groupThree = 'a';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.a' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.a' ) );

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

			$this->setAdvise( 'three', trans( 'flow.combinations.3.b' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.b' ) );

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

			$this->setAdvise( 'three', trans( 'flow.combinations.3.c' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.c' ) );

			return;
		}
		if ( isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'f' ) && ( $data->foods->butter != '1' ) )
		{
			$this->vitamins[] = '3f';
			$this->groupThree = 'f';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.f' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.f' ) );

			return;
		}
		if ( isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'd' ) && ( $data->foods->meat == '1' ) )
		{
			$this->vitamins[] = '3d';
			$this->groupThree = 'd';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.d' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.d' ) );

			return;
		}

		if ( isset( $data->foods->oil ) )
		{
			if ( ( $data->foods->oil == 'fishoil' ) )
			{
				$this->vitamins[] = '3e';
				$this->groupThree = 'e';

				$this->setAdvise( 'three', trans( 'flow.combinations.3.e' ) );
				$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.e' ) );

				return;
			}

			if ( ( $data->foods->oil == 'chiaoil' ) )
			{
				$this->vitamins[] = '3g';
				$this->groupThree = 'g';

				$this->setAdvise( 'three', trans( 'flow.combinations.3.g' ) );
				$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.g' ) );

				return;
			}
		}

		if ( ( ( isset( $data->vegetarian ) && $data->vegetarian == '1' ) ) )
		{
			$this->vitamins[] = '3g';
			$this->groupThree = 'g';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.g' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.g' ) );

			return;
		}
	}

	private function generateGroupTwo( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->two ) )
		{
			$this->groupTwo = $data->custom->two;
			$this->vitamins[] = "2{$data->custom->two}";

			return;
		}

		// A
		if ( $this->combinationIsPossible( $this->groupOne, 'A' ) && ( isset( $data->pregnant ) && $data->pregnant == '1' ) )
		{
			$this->groupTwo = 'A';
			$this->vitamins[] = '2A';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.A' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.A' ) );

			return;
		}

		// B
		if ( $this->combinationIsPossible( $this->groupOne, 'B' ) && ( isset( $data->diet ) && $data->diet == '1' ) )
		{
			$this->groupTwo = 'B';
			$this->vitamins[] = 'B';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.B' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.B' ) );

			return;
		}

		// E
		if ( $this->combinationIsPossible( $this->groupOne, 'E' ) && ( isset( $data->joints ) && $data->joints == '1' ) )
		{
			$this->groupTwo = 'E';
			$this->vitamins[] = 'E';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.E' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.E' ) );

			return;
		}

		// D
		if ( $this->combinationIsPossible( $this->groupOne, 'D' ) && ( isset( $data->smokes ) && $data->smokes == '1' ) )
		{
			$this->groupTwo = 'D';
			$this->vitamins[] = '2D';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.D' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.D' ) );

			return;
		}

		// C
		if ( $this->combinationIsPossible( $this->groupOne, 'C' ) && ( isset( $data->sports ) && $data->sports == '4' ) )
		{
			$this->groupTwo = 'C';
			$this->vitamins[] = '2C';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.C' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.C' ) );

			return;
		}

		// D
		if ( $this->combinationIsPossible( $this->groupOne, 'D' ) && ( isset( $data->immune_system ) && $data->immune_system != '1' ) )
		{
			$this->groupTwo = 'D';
			$this->vitamins[] = 'D';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.D' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.D' ) );

			return;
		}

		// C
		if ( $this->combinationIsPossible( $this->groupOne, 'C' ) && ( ( isset( $data->stressed ) && $data->stressed == '1' ) || ( isset( $data->lacks_energy ) && $data->lacks_energy < '3' ) ) )
		{
			$this->groupTwo = 'C';
			$this->vitamins[] = '2C';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.C' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.C' ) );

			return;
		}
	}

	private function generateGroupOne( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->one ) )
		{
			$this->groupOne = $data->custom->one;
			$this->vitamins[] = "1{$data->custom->one}";

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
						$this->groupOne = '1';
						$this->vitamins[] = "1a";

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne = '2';
						$this->vitamins[] = "1b";

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

						return;
					}
				}
				else
				{
					// Dark / med skin
					if ( $data->outside == '1' )
					{
						// Outside
						$this->groupOne = '2';
						$this->vitamins[] = "1b";

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne = '2';
						$this->vitamins[] = "1b";

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

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
						$this->groupOne = '3';
						$this->vitamins[] = "1c";

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne = '3';
						$this->vitamins[] = "1c";

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );

						return;
					}
				}
				else
				{
					// Dark / med skin
					if ( $data->outside == '1' )
					{
						// Outside
						$this->groupOne = '3';
						$this->vitamins[] = "1c";

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne = '3';
						$this->vitamins[] = "1c";

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );

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
				$this->groupOne = '1';
				$this->vitamins[] = "1a";

				$this->setAdvise( 'one', trans( 'flow.combinations.1.basic' ) );
				$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic' ) );

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
							$this->groupOne = '1';
							$this->vitamins[] = "1a";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

							return;
						}
					}
					else
					{
						// Dark / med skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

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
							$this->groupOne = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

							return;
						}
					}
					else
					{
						// Dark / med skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '2';
							$this->vitamins[] = "1b";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );

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
							$this->groupOne = '3';
							$this->vitamins[] = "1c";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '3';
							$this->vitamins[] = "1c";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
					}
					else
					{
						// Dark / med skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne = '3';
							$this->vitamins[] = "1c";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '3';
							$this->vitamins[] = "1c";

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
					}
				}
			}
		}
	}
}