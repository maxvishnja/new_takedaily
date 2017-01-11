<?php

// Yeah.. this is not very type-safe.. honestly I don't even know the types (integers or strings..)
// So I rely on PHP to do what it does "best": ignore types.

namespace App\Apricot\Libraries;

use App\Vitamin;

class CombinationLibraryNew
{
	private $textGenerator;

	private $groupOne;
	private $groupTwo;
	private $groupThree;

	private $vitamins    = [];
	private $advises     = [];
	private $advise_info = [];

	public function __construct()
	{
		$this->textGenerator = new CombinationTextGenerator();
	}

	public function getPillNames()
	{
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
				return (string) $vitamin === '3e' || (string) $vitamin === '3g';
			} )->count() > 0;
	}

	public function getResult()
	{
		return $this->vitamins;
	}

	public function getAdvises()
	{
		return $this->advises;
	}

	public function getAdviseInfos()
	{
		return $this->advise_info;
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

	public function generateResult( $data )
	{
		if ( ! isset( $data->gender ) && ! isset( $data->custom ) )
		{
			return [];
		}

		if ( isset( $data->locale, $data->pregnant ) && $data->locale === 'nl' && $data->pregnant == '1' )
		{
			$this->groupOne   = 'A';
			$this->groupTwo   = 'd';
			$this->groupThree = 'e';
			$this->vitamins[] = '2A';
			$this->vitamins[] = '3d';
			$this->vitamins[] = '3e';

			if ( $data->pregnancy->wish == '1' )
			{
				$this->setAdvise( '2A', $this->textGenerator->generate( '2A.wish', [ 'wish' ], true ) );
			}
			else
			{
				$this->setAdvise( '2A', $this->textGenerator->generate( '2A.pregnant', [ 'pregnant' ], true ) );
			}
			$this->setAdviseInfo( '2A', trans( 'flow.combination_info.2.A' ) );

			$this->setAdvise( '3d', $this->textGenerator->generate( '3d', [ 'pregnant' ], true ) );
			$this->setAdviseInfo( '3d', trans( 'flow.combination_info.3.d' ) );

			$this->setAdvise( '3e', $this->textGenerator->generate( '3e', [ 'pregnant' ], true ) );
			$this->setAdviseInfo( '3e', trans( 'flow.combination_info.3.e' ) );
		}

		if ( $this->groupOne === null )
		{
			$this->generateGroupOne( $data );
		}

		if ( $this->groupTwo === null )
		{
			$this->generateGroupTwo( $data );
		}

		if ( $this->groupThree === null )
		{
			$this->generateGroupThree( $data );
		}

		if ( count( $this->vitamins ) < 3 )
		{
			if ( $this->groupTwo === null )
			{
				$this->setAdvise( 'no-lifestyle', trans( 'flow.combinations.no-lifestyle' ) );
			}

			if ( $this->groupThree === null )
			{
				$this->setAdvise( 'no-diet', trans( 'flow.combinations.no-diet' ) );
			}

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
		if ( isset( $data->custom, $data->custom->three ) && $data->custom->three !== '' && ! empty( $data->custom->three ) )
		{
			$this->vitamins[] = "3{$data->custom->three}";
			$this->groupThree = $data->custom->three;
//			$this->setAdvise( "3{$data->custom->three}", trans( "flow.combinations.3.{$data->custom->three}" ) );
			$this->setAdvise( "3{$data->custom->three}", $this->textGenerator->generate( "3{$data->custom->three}", [], true ) );
			$this->setAdviseInfo( "3{$data->custom->three}", trans( "flow.combination_info.3.{$data->custom->three}" ) );

			return;
		}

		if ( CombinationChecker::isAllowed( $this->groupOne, $this->groupTwo, 'd' ) && isset( $data->vegetarian ) && $data->vegetarian == '1' )
		{
			$this->vitamins[] = '3d';
			$this->groupThree = 'd';

//			$this->setAdvise( '3d', trans( 'flow.combinations.3.d' ) );
			$this->setAdvise( '3d', $this->textGenerator->generate( '3d', [ 'vegetarian' ], true ) );
			$this->setAdviseInfo( '3d', trans( 'flow.combination_info.3.d' ) );

			return;
		}

		if ( CombinationChecker::isAllowed( $this->groupOne, $this->groupTwo, 'e' ) && isset( $data->foods, $data->locale, $data->foods->fish )
		     && (
			     ( $data->locale === 'da' && $data->foods->fish != '3' )
			     ||
			     ( $data->locale === 'nl' && $data->foods->fish == '1' )
		     )
		)
		{
			$this->vitamins[] = '3e';
			$this->groupThree = '3';

			$this->setAdvise( '3e', $this->textGenerator->generate( '3e', [ 'fish' ], true ) );
			$this->setAdviseInfo( '3e', trans( 'flow.combination_info.3.e' ) );

			return;
		}

		if ( CombinationChecker::isAllowed( $this->groupOne, $this->groupTwo, 'a' ) && isset( $data->foods, $data->locale ) &&
		     ( ( $data->locale === 'nl'
		         && ( $data->foods->fruits == '1'
		              || $data->foods->fruits == '2'
		              || $data->foods->vegetables == '1'
		              || $data->foods->vegetables == '2' )
		       ) ||
		       ( $data->locale === 'da'
		         && ( ( (
			                $data->foods->fruits != '3'
			                && $data->foods->vegetables != '4'
		                )
		                ||
		                (
			                $data->foods->fruits == '3'
			                && $data->foods->vegetables == '1'
		                ) ) && $data->foods->vegetables != '4' )
		       ) )

		)
		{
			$this->vitamins[] = '3a';
			$this->groupThree = 'a';

			$reasons = [];

			if ( $data->locale === 'nl' )
			{
				if ( $data->foods->fruits == '1' || $data->foods->fruits == '2' )
				{
					$reasons[] = 'fruits';
				}

				if ( $data->foods->vegetables == '1' || $data->foods->vegetables == '2' )
				{
					$reasons[] = 'vegetables';
				}
			}
			elseif ( $data->locale === 'da' )
			{

				if ( $data->foods->fruits == '1' || $data->foods->fruits == '2' )
				{
					$reasons[] = 'fruits';
				}

				if ( $data->foods->vegetables != '4' )
				{
					$reasons[] = 'vegetables';
				}
			}

			$this->setAdvise( '3a', $this->textGenerator->generate( '3a', $reasons, true ) );
			$this->setAdviseInfo( '3a', trans( 'flow.combination_info.3.a' ) );

			return;
		}

		if ( CombinationChecker::isAllowed( $this->groupOne, $this->groupTwo, 'b' ) && isset( $data->gender, $data->age, $data->foods, $data->locale ) &&
		     (
			     (
				     $data->locale === 'nl' &&
				     ( ( $data->foods->bread == '1' || $data->foods->wheat == '1' )
				       || ( $data->age >= '51' && $data->foods->bread < '3' )
				       || ( ( $data->gender == '2' && $data->foods->bread < '4' ) || ( $data->gender == '1' && $data->foods->bread != '4' ) )
				       || ( $data->gender == '1' && $data->age <= '70' && $data->foods->bread != '5' )
				       || ( $data->age > '50' && $data->foods->wheat != '3' )
				       || ( $data->age <= '50' && $data->foods->wheat != '4' ) )
			     )
			     ||
			     (
				     $data->locale === 'da' &&
				     ( $data->foods->bread == '1' || $data->foods->wheat <= '2' )
			     )
		     )
		)
		{
			$this->vitamins[] = '3b';
			$this->groupThree = 'b';

			$reasons = [];

			if ( $data->locale === 'nl' )
			{
				if ( ( $data->foods->wheat == '1' )
				     || ( $data->age > '50' && $data->foods->wheat != '3' )
				     || ( $data->age <= '50' && $data->foods->wheat != '4' )
				)
				{
					$reasons[] = 'wheat';
				}

				if ( ( $data->foods->bread == '1' )
				     || ( $data->age >= '51' && $data->foods->bread < '3' )
				     || ( ( $data->gender == '2' && $data->foods->bread < '4' ) || ( $data->gender == '1' && $data->foods->bread != '4' ) )
				     || ( $data->gender == '1' && $data->age <= '70' && $data->foods->bread != '5' )
				)
				{
					$reasons[] = 'bread';
				}
			}
			elseif ( $data->locale === 'da' )
			{
				if ( $data->foods->wheat == '1' )
				{
					$reasons[] = 'wheat';
				}

				if ( $data->foods->bread <= '2' )
				{
					$reasons[] = 'bread';
				}
			}

			$this->setAdvise( '3b', $this->textGenerator->generate( '3b', $reasons, true ) );
			$this->setAdviseInfo( '3b', trans( 'flow.combination_info.3.b' ) );

			return;
		}


		if ( CombinationChecker::isAllowed( $this->groupOne, $this->groupTwo, 'c' ) && isset( $data->age, $data->foods, $data->locale ) && (
				( $data->locale === 'nl' && ( ( $data->foods->dairy == '1' )
				                              || ( $data->age <= '50' && $data->foods->dairy < '3' )
				                              || ( $data->age > '50' && $data->foods->dairy < '4' ) ) )
				||
				( $data->locale === 'da' && ( $data->foods->dairy == '1' || $data->foods->dairy == '2' ) )
			)
		)
		{
			$this->vitamins[] = '3c';
			$this->groupThree = 'c';

			$this->setAdvise( '3c', $this->textGenerator->generate( '3c', [ 'dairy' ], true ) );
			$this->setAdviseInfo( '3c', trans( 'flow.combination_info.3.c' ) );

			return;
		}
		if ( CombinationChecker::isAllowed( $this->groupOne, $this->groupTwo, 'f' ) && isset( $data->foods ) && ( $data->foods->butter != '1' ) )
		{
			$this->vitamins[] = '3f';
			$this->groupThree = 'f';

			$this->setAdvise( '3f', $this->textGenerator->generate( '3f', [ 'butter' ], true ) );
			$this->setAdviseInfo( '3f', trans( 'flow.combination_info.3.f' ) );

			return;
		}
		if ( CombinationChecker::isAllowed( $this->groupOne, $this->groupTwo, 'd' ) && isset( $data->foods ) && ( $data->foods->meat == '1' ) )
		{
			$this->vitamins[] = '3d';
			$this->groupThree = 'd';

			$this->setAdvise( '3d', $this->textGenerator->generate( '3d', [ 'not_vegetarian_meat' ], true ) );
			$this->setAdviseInfo( '3d', trans( 'flow.combination_info.3.d' ) );

			return;
		}

		if ( isset( $data->foods->oil ) )
		{
			if ( $data->foods->oil === 'fishoil' )
			{
				$this->vitamins[] = '3e';
				$this->groupThree = 'e';

				$this->setAdvise( '3e', $this->textGenerator->generate( '3e', [ 'fishoil' ], true ) );
				$this->setAdviseInfo( '3e', trans( 'flow.combination_info.3.e' ) );

				return;
			}

			if ( $data->foods->oil === 'chiaoil' )
			{
				$this->vitamins[] = '3g';
				$this->groupThree = 'g';

				$this->setAdvise( '3g', $this->textGenerator->generate( '3g', [ 'chiaoil' ], true ) );
				$this->setAdviseInfo( '3g', trans( 'flow.combination_info.3.g' ) );

				return;
			}
		}

		if ( isset( $data->vegetarian ) && $data->vegetarian == '1' )
		{
			$this->vitamins[] = '3g';
			$this->groupThree = 'g';

			$this->setAdvise( '3g', $this->textGenerator->generate( '3g', [ 'vegetarian' ], true ) );
			$this->setAdviseInfo( '3g', trans( 'flow.combination_info.3.g' ) );

			return;
		}
	}

	private function generateGroupTwo( $data )
	{
		if ( isset( $data->custom, $data->custom->two ) )
		{
			$this->groupTwo   = $data->custom->two;
			$this->vitamins[] = "2{$data->custom->two}";

			$this->setAdvise( "2{$data->custom->two}", $this->textGenerator->generate( "2{$data->custom->two}", [], true ) );
			$this->setAdviseInfo( "2{$data->custom->two}", trans( 'flow.combination_info.2.A' ) );

			return;
		}

		// A
		if ( isset( $data->pregnant ) && $data->pregnant == '1' )
		{
			$this->groupTwo   = 'A';
			$this->vitamins[] = '2A';

			if ( $data->pregnancy->wish == '1' )
			{
				$this->setAdvise( '2A', $this->textGenerator->generate( '2A.wish', [ 'wish' ], true ) );
			}
			else
			{
				$this->setAdvise( '2A', $this->textGenerator->generate( '2A.pregnant', [ 'pregnant' ], true ) );
			}
			$this->setAdviseInfo( '2A', trans( 'flow.combination_info.2.A' ) );

			return;
		}

		// B
		if ( isset( $data->diet ) && $data->diet == '1' )
		{
			$this->groupTwo   = 'B';
			$this->vitamins[] = '2B';

			$this->setAdvise( '2B', $this->textGenerator->generate( '2B', [ 'diet' ], true ) );
			$this->setAdviseInfo( '2B', trans( 'flow.combination_info.2.B' ) );

			return;
		}

		// E
		if ( isset( $data->joints ) && $data->joints == '1' )
		{
			$this->groupTwo   = 'E';
			$this->vitamins[] = '2E';

			$this->setAdvise( '2E', $this->textGenerator->generate( '2E', [ 'joints' ], true ) );
			$this->setAdviseInfo( '2E', trans( 'flow.combination_info.2.E' ) );

			return;
		}

		// D
		if ( isset( $data->smokes ) && $data->smokes == '1' )
		{
			$this->groupTwo   = 'D';
			$this->vitamins[] = '2D';

			$this->setAdvise( '2D', $this->textGenerator->generate( '2D', [ 'smokes' ], true ) );
			$this->setAdviseInfo( '2D', trans( 'flow.combination_info.2.D' ) );

			return;
		}

		// C
		if ( isset( $data->sports ) && $data->sports == '4' )
		{
			$this->groupTwo   = 'C';
			$this->vitamins[] = '2C';

			$this->setAdvise( '2C', $this->textGenerator->generate( '2C', [ 'sports' ], true ) );
			$this->setAdviseInfo( '2C', trans( 'flow.combination_info.2.C' ) );

			return;
		}

		// D
		if ( isset( $data->immune_system ) && $data->immune_system != '1' )
		{
			$this->groupTwo   = 'D';
			$this->vitamins[] = '2D';

			$this->setAdvise( '2D', $this->textGenerator->generate( '2D', [ 'immune_system' ], true ) );
			$this->setAdviseInfo( '2D', trans( 'flow.combination_info.2.D' ) );

			return;
		}

		// C
		if ( ( isset( $data->stressed ) && $data->stressed == '1' ) || ( isset( $data->lacks_energy ) && $data->lacks_energy < '3' ) )
		{
			$this->groupTwo   = 'C';
			$this->vitamins[] = '2C';

			$this->setAdvise( '2C', $this->textGenerator->generate( '2C', [ 'lacks_energy_stressed' ], true ) );
			$this->setAdviseInfo( '2C', trans( 'flow.combination_info.2.C' ) );

			return;
		}
	}

	private function generateGroupOne( $data )
	{
		if ( isset( $data->custom, $data->custom->one ) )
		{
			$this->groupOne   = $data->custom->one;
			$this->vitamins[] = "1{$data->custom->one}";

			$this->setAdvise( "1{$data->custom->one}", $this->textGenerator->generate( "1{$data->custom->one}", [], true ) );
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
						$this->vitamins[] = '1a';

						$this->setAdvise( '1a', $this->textGenerator->generate( '1a', [] ) );
						$this->setAdviseInfo( '1a', trans( 'flow.combination_info.1.basic' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne   = '2';
						$this->vitamins[] = '1b';

						$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'outside' ] ) );
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
						$this->vitamins[] = '1b';

						$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'skin' ] ) );
						$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne   = '2';
						$this->vitamins[] = '1b';

						$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'skin' ] ) );
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
						$this->vitamins[] = '1c';

						$this->setAdvise( '1c', $this->textGenerator->generate( '1c', [] ) );
						$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne   = '3';
						$this->vitamins[] = '1c';

						$this->setAdvise( '1c', $this->textGenerator->generate( '1c', [] ) );
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
						$this->vitamins[] = '1c';

						$this->setAdvise( '1c', $this->textGenerator->generate( '1c', [] ) );
						$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

						return;
					}
					elseif ( $data->outside == '2' )
					{
						// Not outside
						$this->groupOne   = '3';
						$this->vitamins[] = '1c';

						$this->setAdvise( '1c', $this->textGenerator->generate( '1c', [] ) );
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
				$this->vitamins[] = '1a';

				$this->setAdvise( '1a', $this->textGenerator->generate( '1a', [] ) );
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
							$this->vitamins[] = '1a';

							$this->setAdvise( '1a', $this->textGenerator->generate( '1a', [] ) );
							$this->setAdviseInfo( '1a', trans( 'flow.combination_info.1.basic' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '2';
							$this->vitamins[] = '1b';

							$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'outside' ] ) );
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
							$this->vitamins[] = '1b';

							$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'skin' ] ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '2';
							$this->vitamins[] = '1b';

							$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'skin' ] ) );
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
							$this->vitamins[] = '1b';

							$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'age' ] ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '2';
							$this->vitamins[] = '1b';

							$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'age' ] ) );
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
							$this->vitamins[] = '1b';

							$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'age' ] ) );
							$this->setAdviseInfo( '1b', trans( 'flow.combination_info.1.basic-10-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '2';
							$this->vitamins[] = '1b';

							$this->setAdvise( '1b', $this->textGenerator->generate( '1b', [ 'age' ] ) );
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
							$this->vitamins[] = '1c';

							$this->setAdvise( '1c', $this->textGenerator->generate( '1c', [] ) );
							$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '3';
							$this->vitamins[] = '1c';

							$this->setAdvise( '1c', $this->textGenerator->generate( '1c', [] ) );
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
							$this->vitamins[] = '1c';

							$this->setAdvise( '1c', $this->textGenerator->generate( '1c', [] ) );
							$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
						elseif ( $data->outside == '2' )
						{
							// Not outside
							$this->groupOne   = '3';
							$this->vitamins[] = '1c';

							$this->setAdvise( '1c', $this->textGenerator->generate( '1c', [] ) );
							$this->setAdviseInfo( '1c', trans( 'flow.combination_info.1.basic-20-d' ) );

							return;
						}
					}
				}
			}
		}
	}
}