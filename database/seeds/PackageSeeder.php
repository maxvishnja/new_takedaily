<?php

use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Package::create([
        	'identifier' => 'busy_life',
            'group_one' => '*',
            'group_two' => 'C',
            'group_three' => 'a|e'
        ]);

        \App\Package::create([
        	'identifier' => 'relax',
            'group_one' => '*',
            'group_two' => 'C',
            'group_three' => 'a|e'
        ]);

        \App\Package::create([
        	'identifier' => 'sportsman_woman',
            'group_one' => '*',
            'group_two' => 'C',
            'group_three' => 'a|e'
        ]);

        \App\Package::create([
        	'identifier' => 'balanced_body',
            'group_one' => '*',
            'group_two' => 'B',
            'group_three' => 'c|e'
        ]);

        \App\Package::create([
        	'identifier' => 'immunity_boost',
            'group_one' => '*',
            'group_two' => 'D',
            'group_three' => 'c|e'
        ]);

        \App\Package::create([
        	'identifier' => 'vega_power',
            'group_one' => '*',
            'group_two' => 'D',
            'group_three' => 'e,g'
        ]);

        \App\Package::create([
        	'identifier' => 'women_menopause',
            'group_one' => '2',
            'group_two' => 'E',
            'group_three' => 'c'
        ]);

        \App\Package::create([
        	'identifier' => 'heart_bloodvessels',
            'group_one' => '*',
            'group_two' => 'B',
            'group_three' => 'e'
        ]);

        \App\Package::create([
        	'identifier' => 'beauty_boost',
            'group_one' => '*',
            'group_two' => 'D',
            'group_three' => 'c|e'
        ]);

        \App\Package::create([
        	'identifier' => 'pregnant',
            'group_one' => '1',
            'group_two' => 'A',
            'group_three' => 'e'
        ]);
    }
}
