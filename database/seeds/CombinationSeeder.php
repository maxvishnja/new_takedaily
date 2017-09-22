<?php

use Illuminate\Database\Seeder;

class CombinationSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$combinations = json_decode('{
	"1": {
		"A": {
			"a": false,
			"b": false,
			"c": true,
			"d": true,
			"e": true,
			"f": false,
			"g": true
		},
		"B": {
			"a": false,
			"b": false,
			"c": true,
			"d": false,
			"e": true,
			"f": true,
			"g": true
		},
		"C": {
			"a": true,
			"b": false,
			"c": false,
			"d": false,
			"e": true,
			"f": true,
			"g": true
		},
		"D": {
			"a": false,
			"b": false,
			"c": true,
			"d": false,
			"e": true,
			"f": false,
			"g": true
		},
		"E": {
			"a": true,
			"b": true,
			"c": true,
			"d": true,
			"e": true,
			"f": false,
			"g": true
		}
	},
	"2": {
		"A": false,
		"B": {
			"a": false,
			"b": false,
			"c": true,
			"d": false,
			"e": true,
			"f": true,
			"g": true
		},
		"C": {
			"a": true,
			"b": false,
			"c": false,
			"d": false,
			"e": true,
			"f": true,
			"g": true
		},
		"D": {
			"a": false,
			"b": false,
			"c": true,
			"d": false,
			"e": true,
			"f": false,
			"g": true
		},
		"E": {
			"a": true,
			"b": true,
			"c": true,
			"d": true,
			"e": true,
			"f": false,
			"g": true
		}
	},
	"3": {
		"A": false,
		"B": {
			"a": false,
			"b": false,
			"c": true,
			"d": false,
			"e": true,
			"f": false,
			"g": true
		},
		"C": {
			"a": true,
			"b": false,
			"c": false,
			"d": false,
			"e": true,
			"f": false,
			"g": true
		},
		"D": false,
		"E": false
	}
}', true);

		foreach ( $combinations as $combinationGroupOne => $combinationGroupOneContent )
		{
			if ( is_array($combinationGroupOneContent) )
			{
				foreach ( $combinationGroupOneContent as $combinationGroupTwo => $combinationGroupTwoContent )
				{
					if ( is_array($combinationGroupTwoContent) )
					{
						foreach ( $combinationGroupTwoContent as $combinationGroupThree => $combinationGroupThreeContent )
						{
							\App\Combination::create([
								'combination_possible' => $combinationGroupThreeContent,
								'combination_result'   => $combinationGroupThreeContent ? "{$combinationGroupOne}|{$combinationGroupTwo}|{$combinationGroupThree}" : "{$combinationGroupOne}|{$combinationGroupTwo}",
								'group_1'              => $combinationGroupOne,
								'group_2'              => $combinationGroupTwo,
								'group_3'              => $combinationGroupThree
							]);
						}
					}
					else
					{
						\App\Combination::create([
							'combination_possible' => $combinationGroupTwoContent,
							'combination_result'   => $combinationGroupTwoContent ? "{$combinationGroupOne}|{$combinationGroupTwo}" : "{$combinationGroupOne}",
							'group_1'              => $combinationGroupOne,
							'group_2'              => $combinationGroupTwo,
							'group_3'              => ''
						]);
					}
				}
			}
		}
	}
}
