<?php
namespace App\Apricot\Libraries;


use App\Combination;

class CombinationLibrary
{
	private $groupOne = null;
	private $groupTwo = null;
	private $groupThree = null;

	function __construct() { }

	function isEmpty($group)
	{
		return is_null($group);
	}

	function getResult()
	{
		return [
			'one'   => $this->groupOne,
			'two'   => $this->groupTwo,
			'three' => $this->groupThree
		];
	}

	function combinationIsPossible($groupOne, $groupTwo = null, $groupThree = null)
	{
		$combination = \Cache::remember("combination_possible_{$groupOne}{$groupTwo}{$groupThree}", 30, function () use ($groupOne, $groupTwo, $groupThree)
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
			})->first();
		});

		if ( !$combination )
		{
			return false;
		}

		return $combination->isPossible();
	}

	function generateResult($data)
	{
		/*
		 * Group 1
		 */
		if ( ($data->age < '50 ' && $data->gender == '2 ' && $data->pregnant == '2') || ($data->age < '70 ' && $data->gender == '1') )
		{
			$this->groupOne = '1';
		}
		if ( ($this->isEmpty($this->groupOne)) && ((($data->age >= '50' && $data->age <= '70') && $data->gender == '2)' || ($data->skin > '1') || ($data->outside == '2'))) )
		{
			$this->groupOne = '2';
		}
		if ( ($this->isEmpty($this->groupOne)) && (($data->age >= '70 ' && $data->gender == '1') || ($data->age >= '50' && $data->gender == '2')) && isAlone(1, 1.4) )
		{
			$this->groupOne = '3';
		}

		/*
		 * Group 2
		 */
		if ( $this->combinationIsPossible($this->groupOne, 'A') && $data->pregnant == '1' )
		{
			$this->groupTwo = 'A';
		}
		if ( $this->combinationIsPossible($this->groupOne, 'B') && $this->isEmpty($this->groupTwo) && ($data->diet == '1') )
		{
			$this->groupTwo = 'B';
		}
		if ( $this->combinationIsPossible($this->groupOne, 'C') && $this->isEmpty($this->groupTwo) && ($data->sports == '4' || $data->lacks_energy < '3' || $data->stressed == '1') )
		{
			$this->groupTwo = 'C';
		}
		if ( $this->combinationIsPossible($this->groupOne, 'D') && $this->isEmpty($this->groupTwo) && ($data->immune_system == '1' || $data->smokes == '1' || $data->vegetarian == '1') )
		{
			$this->groupTwo = 'D';
		}
		if ( $this->combinationIsPossible($this->groupOne, 'E') && $this->isEmpty($this->groupTwo) && ($data->joints == '1') )
		{
			$this->groupTwo = 'E';
		}

		/*
		 * Group 3
		 */
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'a') && ($data->foods->fruits == '1' || $data->foods->vegetables == '1') )
		{
			$this->groupThree = 'a';
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'b') && $this->isEmpty($this->groupThree) && ($data->foods->bread == '1' || $data->foods->wheat == '1') )
		{
			$this->groupThree = 'b';
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'c') && $this->isEmpty($this->groupThree) && ($data->foods->dairy == '1') )
		{
			$this->groupThree = 'c';
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'd') && $this->isEmpty($this->groupThree) && ($data->foods->meat == '1') )
		{
			$this->groupThree = 'd';
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'e') && $this->isEmpty($this->groupThree) && ($data->foods->fish == '1') )
		{
			$this->groupThree = 'e';
		}
		if ( $this->combinationIsPossible($this->groupOne, $this->groupTwo, 'f') && $this->isEmpty($this->groupThree) && ($data->foods->butter == '2') )
		{
			$this->groupThree = 'f';
		}
	}
}