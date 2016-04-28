<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\Setting::create([
			'identifier' => 'analytics-code',
			'value'      => ''
		]);

		\App\Setting::create([
			'identifier' => 'share-coupon',
			'value'      => ''
		]);

		\App\Setting::create([
			'identifier' => 'shipping_price',
			'value'      => '39'
		]);
	}
}
