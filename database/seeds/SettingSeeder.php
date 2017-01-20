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

		\App\Setting::create([
			'identifier' => 'da_giftcard_1_price',
			'value'      => '14900'
		]);

		\App\Setting::create([
			'identifier' => 'da_giftcard_3_price',
			'value'      => '44700'
		]);

		\App\Setting::create([
			'identifier' => 'da_giftcard_6_price',
			'value'      => '89400'
		]);

		\App\Setting::create([
			'identifier' => 'da_subscription_price',
			'value'      => '14900'
		]);

		\App\Setting::create([
			'identifier' => 'da_vitamin_price',
			'value'      => '2500'
		]);

		// -- NL

		\App\Setting::create([
			'identifier' => 'nl_giftcard_1_price',
			'value'      => '1895'
		]);

		\App\Setting::create([
			'identifier' => 'nl_giftcard_3_price',
			'value'      => '5685'
		]);

		\App\Setting::create([
			'identifier' => 'nl_giftcard_6_price',
			'value'      => '11370'
		]);

		\App\Setting::create([
			'identifier' => 'nl_subscription_price',
			'value'      => '1895'
		]);

		\App\Setting::create([
			'identifier' => 'nl_vitamin_price',
			'value'      => '350'
		]);
	}
}
