<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\App\Product::create([
			'name' => 'subscription',
			'price' => \App\Apricot\Libraries\MoneyLibrary::toCents(149),
			'is_subscription' => 1
		]);

		\App\Product::create([
			'name' => 'giftcard_1',
			'price' => \App\Apricot\Libraries\MoneyLibrary::toCents(149),
			'is_subscription' => 0
		]);
		\App\Product::create([
			'name' => 'giftcard_3',
			'price' => \App\Apricot\Libraries\MoneyLibrary::toCents(447),
			'is_subscription' => 0
		]);
		\App\Product::create([
			'name' => 'giftcard_6',
			'price' => \App\Apricot\Libraries\MoneyLibrary::toCents(894),
			'is_subscription' => 0
		]);

		\App\Product::create([
			'name' => 'package',
			'price' => \App\Apricot\Libraries\MoneyLibrary::toCents(149),
			'is_subscription' => 1
		]);
    }
}
