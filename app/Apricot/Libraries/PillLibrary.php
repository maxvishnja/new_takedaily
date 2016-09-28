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
	    '3g' => ''
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
		/*$codes = [
			'1a' => '44.000',
			'1b' => '44.000-18.037',
			'1c' => '44.000-04.000',
			'2a' => '38.063 - Pregnant',
			'2b' => '17.196 - Slimming',
			'2c' => '18.385 - Athlete',
			'2d' => '44.000-21.035',
			'2e' => '32.364 - Joint',
			'3a' => '21.035 - Fruit and Vegetable',
			'3b' => '22.027 - Bread Rice',
			'3c' => '44.650 - Dairy',
			'3d' => '43.000 - Vega',
			'3e' => 'N/A - Fish',
			'3f' => '41.019 - Butter',
		];*/

		if ( !isset(self::$codes[ $pill ]) )
		{
			return '';
		}

		return self::$codes[ $pill ];
	}
}