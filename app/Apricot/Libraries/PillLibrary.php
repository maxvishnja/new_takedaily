<?php namespace App\Apricot\Libraries;


class PillLibrary
{
	public static $codes = [
		'1a' => 'Multi Basic',
		'1b' => 'Multi Vitamin D+',
		'1c' => 'Multi Vitamin D+ Extra',
		'2a' => 'Mom & Baby',
		'2b' => 'Shape Me up',
		'2c' => 'Energy Booster',
		'2d' => 'Immune Booster',
//		'2e' => 'Joint & Muscle',
		'2e' => 'Bone & Muscle',
		'3a' => 'I\'m not a veggie fan',
		'3b' => 'I don\'t Eat Carbs',
		'3c' => 'The Dairy Portion',
		'3d' => 'I am Vegetarian / Vegan',
		'3e' => 'Premium Omega-3 Fish Oil',
		'3f' => 'Not a Butter Lover',
	    '3g' => 'Premium Omega-3 Chia Seed Oil'
	];

	public static function getPill($group, $item)
	{
		switch ( $group )
		{
			case 1:
			case 'one':
				$group = 1;
				break;

			case 2:
			case 'two':
				$group = 2;
				break;

			default:
			case 3:
			case 'three':
			case 'four':
			case 'five':
				$group = 3;
				break;
		}

		if ( is_numeric($item) )
		{
			$item = chr(ord('A') + $item - 1);
		}

		return strtolower($group . $item);
	}

	public static function getPillCode($pill)
	{
		if ( !isset(self::$codes[ $pill ]) )
		{
			return '';
		}

		return self::$codes[ $pill ];
	}
}