<?php

use Illuminate\Database\Seeder;

class TaxZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\TaxZone::create([
			'name' => 'denmark',
			'rate' => '25'
		]);

        \App\TaxZone::create([
			'name' => 'norway',
			'rate' => '25'
		]);

        \App\TaxZone::create([
			'name' => 'sweden',
			'rate' => '25'
		]);

        \App\TaxZone::create([
			'name' => 'netherlands',
			'rate' => '21'
		]);

        \App\TaxZone::create([
			'name' => 'poland',
			'rate' => '23'
		]);

        \App\TaxZone::create([
			'name' => 'germany',
			'rate' => '19'
		]);
    }
}
