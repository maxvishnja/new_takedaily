<?php

use Illuminate\Database\Seeder;

class VitaminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$vitamins = \App\Apricot\Libraries\PillLibrary::$codes;

		$groupAssignments = [
			'1a' => 'multi',
			'1b' => 'multi',
			'1c' => 'multi',

			'2a' => 'lifestyle',
			'2b' => 'lifestyle',
			'2c' => 'lifestyle',
			'2d' => 'lifestyle',
			'2e' => 'lifestyle',

			'3a' => 'diet',
			'3b' => 'diet',
			'3c' => 'diet',
			'3d' => 'diet',
			'3e' => 'oil',
			'3f' => 'diet',
			'3g' => 'oil',
		];

		foreach ( $vitamins as $code => $name )
		{
			\App\Vitamin::create([
				'name'        => $name,
				'code'        => $code,
				'description' => '',
				'type'        => $groupAssignments[ $code ]
			]);
		}
	}
}
