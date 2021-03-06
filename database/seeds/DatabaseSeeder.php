<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(CombinationSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(TaxZoneSeeder::class);
        $this->call(CurrencySeeder::class);
    }
}
