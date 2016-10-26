<?php

use Illuminate\Database\Seeder;

class MailFlowSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$mailFlow = \App\MailFlow::create( [
			'name'       => 'Demo flow',
			'identifier' => 'demo-flow',
			'is_active'  => 1
		] );

		$mailFlow->conditions()->create([

		]);
	}
}
