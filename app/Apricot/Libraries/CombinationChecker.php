<?php namespace App\Apricot\Libraries;

class CombinationChecker
{
	private static $notAllowedCombinations = [
		'1Af',
		'1Bf',
	    '1Cb',
	    '1Cd',
	    '1Df',
	    '2Aa',
	    '2Ab',
	    '2Ac',
	    '2Ad',
	    '2Ae',
	    '2Af',
	    '2Bf',
	    '2Cb',
	    '2Cd',
	    '2Df',
	    '2Ef',
	    '3Aa',
	    '3Ab',
	    '3Ac',
	    '3Ad',
	    '3Ae',
	    '3Af',
	    '3Bf',
	    '3Cb',
	    '3Cd',
		'3Df',
		'3Ef'
	];

	public static function isAllowed($groupOne, $groupTwo, $groupThree)
	{
		$combination = $groupOne . strtoupper($groupTwo) . $groupThree;
		$newarray = array_flip(self::$notAllowedCombinations);
		return !isset($newarray[$combination]);
	}
}