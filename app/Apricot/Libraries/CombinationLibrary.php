<?php
namespace App\Apricot\Libraries;

// todo start checking if combination is possible again

use App\Combination;

class CombinationLibrary
{
	private $groupOne    = null;
	private $groupTwo    = null;
	private $groupThree  = null;
	private $groupFour   = null;
	private $groupFive   = null;
	private $advises     = [];
	private $advise_info = [];

	function __construct()
	{
	}

	public function hasOil()
	{
		return $this->groupThree == 'e';
	}

	function isEmpty( $group )
	{
		return is_null( $group );
	}

	function getResult()
	{
		$result = [
			'one'   => $this->groupOne,
			'two'   => $this->groupTwo,
			'three' => $this->groupThree,
//			'four'  => $this->groupFour,
//			'five'  => $this->groupFive
		];

		foreach ( $result as $item => $value )
		{
			if ( is_null( $value ) )
			{
				unset( $result[ $item ] );
			}
		}

		return $result;
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
			return Combination::where( function ( $query ) use ( $groupOne, $groupTwo, $groupThree )
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
				return true; // consider a fix
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
//		$this->generateGroupFour( $data );
//		$this->generateGroupFive( $data );

		if ( is_null( $this->groupOne ) && is_null( $this->groupTwo ) && is_null( $this->groupThree ) && is_null( $this->groupFour ) && is_null( $this->groupFive ) )
		{
			$this->setAdvise( 'none', trans( 'flow.combinations.none' ) );
		}
	}

	private function generateGroupFive( $data )
	{
		/*if ( isset($data->double_oil) && $data->double_oil == '1' )
		{
			$this->groupFive = $this->groupFour;

			$this->setAdvise( 'five', $this->advises['four'] );
			$this->setAdviseInfo( 'five', $this->advise_info['four'] );
		}*/
	}

	private function generateGroupFour( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->four ) )
		{
			$this->groupFour = $data->custom->four;

			return;
		}

		if ( isset( $data->foods->oil ) )
		{
			if ( $this->isEmpty( $this->groupFour ) && ( $data->foods->oil == 'fishoil' ) )
			{
				$this->groupFour = 'e';

				$this->setAdvise( 'four', trans( 'flow.combinations.3.e' ) );
				$this->setAdviseInfo( 'four', trans( 'flow.combination_info.3.e' ) );
			}

			if ( $this->isEmpty( $this->groupFour ) && ( $data->foods->oil == 'chiaoil' ) )
			{
				$this->groupFour = 'g';

				$this->setAdvise( 'four', trans( 'flow.combinations.3.g' ) );
				$this->setAdviseInfo( 'four', trans( 'flow.combination_info.3.g' ) );
			}
		}

		if ( $this->isEmpty( $this->groupFour ) && ( ( isset( $data->vegetarian ) && $data->vegetarian == '2' ) || ( isset( $data->foods ) && ( isset( $data->foods->fish ) && $data->foods->fish == '1' || $data->foods->fish == '2' ) ) ) )
		{
			$this->groupFour = 'e';

			$this->setAdvise( 'four', trans( 'flow.combinations.3.e' ) );
			$this->setAdviseInfo( 'four', trans( 'flow.combination_info.3.e' ) );
		}

		if ( $this->isEmpty( $this->groupFour ) && ( ( isset( $data->vegetarian ) && $data->vegetarian == '1' ) ) )
		{
			$this->groupFour = 'g';

			$this->setAdvise( 'four', trans( 'flow.combinations.3.g' ) );
			$this->setAdviseInfo( 'four', trans( 'flow.combination_info.3.g' ) );
		}
	}

	private function generateGroupThree( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->three ) )
		{
			$this->groupThree = $data->custom->three;

			return;
		}

		if ( isset( $data->vegetarian ) && $data->vegetarian == '1' )
		{
			$this->groupThree = 'd';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.d' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.d' ) );
		}
		if ( isset( $data->foods ) && ($this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'a' ) && $this->isEmpty( $this->groupThree ) && ( $data->foods->fruits == '1' || $data->foods->vegetables == '1' )) )
		{
			$this->groupThree = 'a';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.a' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.a' ) );
		}
		if ( isset( $data->gender ) && isset( $data->age ) && isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'b' ) && $this->isEmpty( $this->groupThree ) && ( ( $data->foods->bread == '1' || $data->foods->wheat == '1' ) || ( $data->gender == '2' && $data->age >= '51' && $data->foods->bread != '3' ) || ( ( $data->gender == '2' && $data->age <= '50' && $data->foods->bread != '4' ) || ( $data->gender == '1' && $data->age >= '70' && $data->foods->bread != '4' ) ) || ( $data->gender == '1' && $data->age <= '70' && $data->foods->bread != '5' ) || ( $data->age > '50' && $data->foods->wheat != '3' ) || ( $data->age <= '50' && $data->foods->wheat != '4' ) ) )
		{
			$this->groupThree = 'b';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.b' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.b' ) );
		}
		if ( isset( $data->age ) && isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'c' ) && $this->isEmpty( $this->groupThree ) && ( ( $data->foods->dairy == '1' ) || ( $data->age <= '50' && $data->foods->dairy < '3' ) || ( $data->age > '50' && $data->foods->dairy < '4' ) ) )
		{
			$this->groupThree = 'c';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.c' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.c' ) );
		}
		if ( isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'f' ) && $this->isEmpty( $this->groupThree ) && ( $data->foods->butter == '2' ) )
		{
			$this->groupThree = 'f';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.f' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.f' ) );
		}
		if ( isset( $data->foods ) && $this->combinationIsPossible( $this->groupOne, $this->groupTwo, 'd' ) && $this->isEmpty( $this->groupThree ) && ( $data->foods->meat == '1' ) )
		{
			$this->groupThree = 'd';

			$this->setAdvise( 'three', trans( 'flow.combinations.3.d' ) );
			$this->setAdviseInfo( 'three', trans( 'flow.combination_info.3.d' ) );
		}
	}

	private function generateGroupTwo( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->two ) )
		{
			$this->groupTwo = $data->custom->two;

			return;
		}

		// A
		if ( $this->combinationIsPossible( $this->groupOne, 'A' ) && ( isset( $data->pregnant ) && $data->pregnant == '1' ) )
		{
			$this->groupTwo = 'A';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.A' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.A' ) );
		}

		// B
		if ( $this->combinationIsPossible( $this->groupOne, 'B' ) && $this->isEmpty( $this->groupTwo ) && ( isset( $data->diet ) && $data->diet == '1' ) )
		{
			$this->groupTwo = 'B';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.B' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.B' ) );
		}

		// E
		if ( $this->combinationIsPossible( $this->groupOne, 'E' ) && $this->isEmpty( $this->groupTwo ) && ( isset( $data->joints ) && $data->joints == '1' ) )
		{
			$this->groupTwo = 'E';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.E' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.E' ) );
		}

		// D
		if ( $this->combinationIsPossible( $this->groupOne, 'D' ) && $this->isEmpty( $this->groupTwo ) && ( isset( $data->smokes ) && $data->smokes == '1' ) )
		{
			$this->groupTwo = 'D';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.D' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.D' ) );
		}

		// C
		if ( $this->combinationIsPossible( $this->groupOne, 'C' ) && $this->isEmpty( $this->groupTwo ) && ( isset( $data->sports ) && $data->sports == '4' ) )
		{
			$this->groupTwo = 'C';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.C' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.C' ) );
		}

		// D
		if ( $this->combinationIsPossible( $this->groupOne, 'D' ) && $this->isEmpty( $this->groupTwo ) && ( isset( $data->immune_system ) && $data->immune_system != '1' ) )
		{
			$this->groupTwo = 'D';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.D' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.D' ) );
		}

		// C
		if ( $this->combinationIsPossible( $this->groupOne, 'C' ) && $this->isEmpty( $this->groupTwo ) && ( ( isset( $data->stressed ) && $data->stressed == '1' ) || ( isset( $data->lacks_energy ) && $data->lacks_energy < '3' )) )
		{
			$this->groupTwo = 'C';

			$this->setAdvise( 'two', trans( 'flow.combinations.2.C' ) );
			$this->setAdviseInfo( 'two', trans( 'flow.combination_info.2.C' ) );
		}
	}

	private function generateGroupOne( $data )
	{
		if ( isset( $data->custom ) && isset( $data->custom->one ) )
		{
			$this->groupOne = $data->custom->one;

			return;
		}

		if ( isset($data->gender) && $data->gender == '1' )
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

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic' ) );
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne = '2';

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );
					}
				}
				else
				{
					// Dark / med skin
					if ( $data->outside == '1' )
					{
						// Outside
						$this->groupOne = '2';

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d' ) );
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne = '2';

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );
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

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne = '3';

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );
					}
				}
				else
				{
					// Dark / med skin
					if ( $data->outside == '1' )
					{
						// Outside
						$this->groupOne = '3';

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne = '3';

						$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
						$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );
					}
				}
			}
		}
		elseif ( isset($data->gender) && $data->gender == '2' )
		{
			// Females
			if ( isset($data->pregnant ) && $data->pregnant == 1 )
			{
				// Pregnant
				$this->groupOne = '1';

				$this->setAdvise( 'one', trans( 'flow.combinations.1.basic' ) );
				$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic' ) );
			}
			else
			{
				// Not pregnant
				if ( isset($data->age) && $data->age < '50' )
				{
					// Below 50 of age
					if ( $data->skin == '1' )
					{
						// White skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne = '1';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic' ) );
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '2';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );
						}
					}
					else
					{
						// Dark / med skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne = '2';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d' ) );
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '2';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );
						}
					}
				}
				elseif ( isset($data->age) && $data->age >= '50' && $data->age < '70' )
				{
					// Between 50-70 of age
					if ( $data->skin == '1' )
					{
						// White skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne = '2';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d' ) );
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '2';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );
						}
					}
					else
					{
						// Dark / med skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne = '2';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d' ) );
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '2';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );
						}
					}
				}
				elseif ( isset($data->age) && $data->age >= '70' )
				{
					// Above 70 of age
					if ( $data->skin == '1' )
					{
						// White skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne = '3';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '3';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );
						}
					}
					else
					{
						// Dark / med skin
						if ( $data->outside == '1' )
						{
							// Outside
							$this->groupOne = '3';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne = '3';

							$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
							$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-20-d' ) );
						}
					}
				}
			}
		}

		/*// Multi basic
		if ( ( $this->isEmpty( $this->groupOne ) ) && ( $data->age < '50' && $data->gender == '2' ) || ( $data->age < '70' && $data->gender == '1' ) )
		{
			$this->groupOne = '1';

			$this->setAdvise( 'one', trans( 'flow.combinations.1.basic' ) );
			$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic' ) );
		}

		// Multi D+
		if ( ( $this->isEmpty( $this->groupOne ) ) && ( ( ( $data->age >= '50' && $data->age <= '70' ) && $data->gender == '2' || ( $data->skin > '1' ) || ( $data->outside == '2' ) ) ) )
		{
			$this->groupOne = '2';

			if ( ( $data->age >= '50' && $data->age <= '70' && $data->gender == '2' ) || $data->skin > '1' )
			{
				$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d' ) );
				$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d' ) );
			}

			if ( $data->outside == '2' )
			{
				$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-10-d-alt' ) );
				$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic-10-d-alt' ) );
			}
		}

		// Multi D+ Extra
		if ( ( $this->isEmpty( $this->groupOne ) ) && ( ( $data->age >= '70' && $data->gender == '1' ) || ( $data->age >= '50' && $data->gender == '2' ) ) )
		{
			$this->groupOne = '3';

			$this->setAdvise( 'one', trans( 'flow.combinations.1.basic-20-d' ) );
			$this->setAdviseInfo( 'one', trans( 'flow.combination_info.1.basic.20-d' ) );
		}*/
	}
}