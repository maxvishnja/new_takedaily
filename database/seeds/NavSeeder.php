<?php

use Illuminate\Database\Seeder;

class NavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Nav::create([
        	'path' => 'gifting',
            'title' => 'gifting'
        ]);

        \App\Nav::create([
        	'path' => 'sadan-virker-det',
            'title' => 'how-works'
        ]);

        \App\Nav::create([
        	'path' => 'test-kvalitet',
            'title' => 'test'
        ]);

        \App\Nav::create([
        	'path' => 'about',
            'title' => 'about'
        ]);

        \App\Nav::create([
        	'path' => 'a-zink',
            'title' => 'a-zink'
        ]);
    }
}
