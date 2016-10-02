<?php
namespace App\Apricot\Libraries;


use App\Combination;

class CombinationLibrary
{
	private $groupOne = null;
	private $groupTwo = null;
	private $groupThree = null;
	private $groupFour = null;
	private $advises = [];
	private $advise_info = [];

	function __construct()
	{
	}

	function isEmpty($group)
	{
		return is_null($group);
	}

	function getResult()
	{
		return [
			'one'   => $this->groupOne,
			'two'   => $this->groupTwo,
			'three' => $this->groupThree,
			'four' => $this->groupFour,
		];
	}

	function getAdvises()
	{
		return $this->advises;
	}

	function getAdviseInfos()
	{
		return $this->advise_info;
	}

	function combinationIsPossible($groupOne, $groupTwo = null, $groupThree = null)
	{
		$combination = \Cache::remember("combination_{$groupOne}{$groupTwo}{$groupThree}", 30, function () use ($groupOne, $groupTwo, $groupThree)
		{
			return Combination::where(function ($query) use ($groupOne, $groupTwo, $groupThree)
			{
				$query->where('group_1', "$groupOne");

				if ( !is_null($groupTwo) )
				{
					$query->where('group_2', "$groupTwo");
				}

				if ( !is_null($groupThree) )
				{
					$query->where('group_3', "$groupThree");
				}
				else
				{
					$query->whereNull('group_3');
				}
			})->first();
		});

		if ( !$combination )
		{
			if ( !is_null($groupThree) )
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

	private function setAdvise($num = 'one', $advise)
	{
		if ( !isset($this->advises[ $num ]) )
		{
			$this->advises[ $num ] = $advise;
		}
	}

	private function setAdviseInfo($num = 'one', $advise)
	{
		if ( !isset($this->advise_info[ $num ]) )
		{
			$this->advise_info[ $num ] = $advise;
		}
	}

	function generateResult($data)
	{
		/*
		 * Group 1
		 */
		if ( ($data->age < '50 ' && $data->gender == '2 ' && $data->pregnant == '2') || ($data->age < '70 ' && $data->gender == '1') )
		{
			$this->groupOne = '1';

			$this->setAdvise('one', trans('flow.combinations.1.basic'));
			$this->setAdviseInfo('one', trans('flow.combination_info.1.basic'));
		}
		if ( ($this->isEmpty($this->groupOne)) && ((($data->age >= '50' && $data->age <= '70') && $data->gender == '2)' || ($data->skin > '1') || ($data->outside == '2'))) )
		{
			$this->groupOne = '2';

			if ( ($data->age >= '50' && $data->age <= '70' && $data->gender == '2') || $data->skin > '1' )
			{
				$this->setAdvise('one', trans('flow.combinations.1.basic-10-d'));
				$this->setAdviseInfo('one', trans('flow.combination_info.1.basic-10-d'));
			}

			if ( $data->outside == '2' )
			{
				$this->setAdvise('one', trans('flow.combinations.1.basic-10-d-alt'));
				$this->setAdviseInfo('one', trans('flow.combination_info.1.basic-10-d-alt'));
			}
		}
		if ( ($this->isEmpty($this->groupOne)) && (($data->age >= '70 ' && $data->gender == '1') || ($data->age >= '50' && $data->gender == '2')) )
		{
			$this->groupOne = '3';

			$this->setAdvise('one', trans('flow.combinations.1.basic-20-d'));
			$this->setAdviseInfo('one', trans('flow.combination_info.1.basic.20-d'));
		}

		/*
		 * Group 2
		 */
		if ( $this->combinationIsPossible($this->groupOne, 'A') && ($data->pregnant == '1') )
		{
			$this->groupTwo = 'A';

			$this->setAdvise('two', trans('flow.combinations.2.A'));
			$this->setAdviseInfo('two', trans('flow.combination_info.2.A'));
		}
		if ( $this->combinationIsPossible($this->groupOne, 'B') && $this->isEmpty($this->groupTwo) && ($data->diet == '1') )
		{
			$this->groupTwo = 'B';

			$this->setAdvise('two', trans('flow.combinations.2.B'));
			$this->setAdviseInfo('two', trans('flow.combination_info.2.B'));
		}
		if ( $this->combinationIsPossible($this->groupOne, 'C') && $this->isEmpty($this->groupTwo) && ($data->sports == '4' || $data->lacks_energy < '3' || $data->stressed == '1') )
		{
			$this->groupTwo = 'C';

			$this->setAdvise('two', trans('flow.combinations.2.C'));
			$this->setAdviseInfo('two', trans('flow.combination_info.2.C'));
		}
		if ( $this->combinationIsPossible($this->groupOne, 'D') && $this->isEmpty($this->groupTwo) && ($data->immune_system == '1' || $data->smokes == '1' || $data->vegetarian == '1') )
		{
			$this->groupTwo = 'D';

			$this->setAdvise('two', trans('flow.combinations.2.D'));
			$this->setAdviseInfo('two', trans('flow.combination_info.2.D'));
		}
		if ( $this->combinationIsPossible($this->groupOne, 'E') && $this->isEmpty($this->groupTwo) && ($data->joints == '1') )
		{
			$this->groupTwo = 'E';

			$this->setAdvise('two', trans('flow.combinations.2.E'));
			$this->setAdviseInfo('two', trans('flow.combination_info.2.E'));
		}

		/*
		 * Group 3
		 */
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'a') && ($data->foods->fruits == '1' || $data->foods->vegetables == '1') )
		{
			$this->groupThree = 'a';

			$this->setAdvise('three', trans('flow.combinations.3.a'));
			$this->setAdviseInfo('three', trans('flow.combination_info.3.a'));
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'b') && $this->isEmpty($this->groupThree) && ($data->foods->bread == '1' || $data->foods->wheat == '1') )
		{
			$this->groupThree = 'b';

			$this->setAdvise('three', trans('flow.combinations.3.b'));
			$this->setAdviseInfo('three', trans('flow.combination_info.3.b'));
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'c') && $this->isEmpty($this->groupThree) && ($data->foods->dairy == '1') )
		{
			$this->groupThree = 'c';

			$this->setAdvise('three', trans('flow.combinations.3.c'));
			$this->setAdviseInfo('three', trans('flow.combination_info.3.c'));
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'd') && $this->isEmpty($this->groupThree) && ($data->foods->meat == '1') )
		{
			$this->groupThree = 'd';

			$this->setAdvise('three', trans('flow.combinations.3.d'));
			$this->setAdviseInfo('three', trans('flow.combination_info.3.d'));
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'f') && $this->isEmpty($this->groupThree) && ($data->foods->butter == '2') )
		{
			$this->groupThree = 'f';

			$this->setAdvise('three', trans('flow.combinations.3.f'));
			$this->setAdviseInfo('three', trans('flow.combination_info.3.f'));
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'g') && $this->isEmpty($this->groupThree) && ($data->vegetarian == '1' || $data->foods->fish != '1') && $data->foods->oil == 'chiaoil' )
		{
			$this->groupThree = 'g';

			$this->setAdvise('three', trans('flow.combinations.3.g')); // todo need info
			$this->setAdviseInfo('three', trans('flow.combination_info.3.g')); // todo need info
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'e') && $this->isEmpty($this->groupThree) && ($data->foods->fish == '1' || $data->foods->oil == 'fishoil') )
		{
			$this->groupThree = 'e';

			$this->setAdvise('three', trans('flow.combinations.3.e'));
			$this->setAdviseInfo('three', trans('flow.combination_info.3.e'));
		}

		if ( $this->isEmpty($this->groupFour) && $this->groupThree != 'e' && $this->groupThree != 'g' && ($data->foods->oil == 'fishoil') )
		{
			$this->groupFour = 'e';

			$this->setAdvise('four', trans('flow.combinations.3.e'));
			$this->setAdviseInfo('four', trans('flow.combination_info.3.e'));
		}

		if ( $this->isEmpty($this->groupFour) && $this->groupThree != 'e' && $this->groupThree != 'g' && ($data->foods->oil == 'chiaoil') )
		{
			$this->groupFour = 'g';

			$this->setAdvise('four', trans('flow.combinations.3.g'));
			$this->setAdviseInfo('four', trans('flow.combination_info.3.g'));
		}

		if ( is_null($this->groupOne) && is_null($this->groupTwo) && is_null($this->groupThree) )
		{
			$this->setAdvise('none', trans('flow.combinations.none'));
		}
	}
}