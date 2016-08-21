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
		$vitamins = \App\Apricot\Libraries\PillLibrary::$codes; // ewww.. wtf dude.. git blame.. oh.. it's me.. again.

		foreach ( $vitamins as $code => $name )
		{
			\App\Vitamin::create([
				'name'        => $name,
				'code'        => $code,
				'description' => ''
			]);
		}
	}
}
