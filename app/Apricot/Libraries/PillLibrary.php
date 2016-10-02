<?php namespace App\Apricot\Libraries;


class PillLibrary
{
	/*public static $codes = [
		'1a' => 'Red-White 17-63K/20-1K',
		'1b' => 'Green-White 10-9K/20-1K',
		'1c' => 'Blue-White 4-57K(B)20-1K',
		'2a' => 'Buff 6 - 3K(D)',
		'2b' => 'Light Blue 4 27K(A)',
		'2c' => 'Green Semi Transp. 10-4K',
		'2d' => 'Orange  Code 14-21K',
		'2e' => 'Dark Yellow Code 19-155K',
		'3a' => 'Green Opaque 10-567K',
		'3b' => 'Swed.Orange 17-486K(C)',
		'3c' => 'Yellow 19-103K(A)',
		'3d' => 'Transparant Code 1-0K',
		'3e' => 'Fish',
		'3f' => 'White Code 20-1K',
	];*/
	public static $codes = [
		'1a' => 'Multi Basic',
		'1b' => 'Multi Vitamin D+',
		'1c' => 'Multi Vitamin D+ Extra',
		'2a' => 'Mom & Baby',
		'2b' => 'Shape Me up',
		'2c' => 'Energy Booster',
		'2d' => 'Immune Booster',
		'2e' => 'Bone & joint',
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
			case 'one':
				$group = 1;
				break;
			case 'two':
				$group = 2;
				break;
			case 'three':
			case 'four':
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