<?php namespace App\Apricot\Libraries;


class PillLibrary
{
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
		$codes = [
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
		];

		if ( !isset($codes[ $pill ]) )
		{
			return '';
		}

		return $codes[ $pill ];
	}
}