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
}