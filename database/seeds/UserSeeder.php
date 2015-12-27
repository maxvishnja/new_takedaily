<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\User::create([
			'name'     => 'John Doe',
			'email'    => 'admin@takedaily.app',
			'password' => Hash::make('admin-account')
		]);
	}
}
