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
		// For women +50 years of age
		$mailflow_woman_plus_50 = \App\MailFlow::create( [
			'name'       => 'Woman +50 of age',
			'identifier' => 'woman-above-50',
		    'should_auto_match' => 1
		] );

		$mailflow_woman_plus_50->conditions()->create( [
			'key'   => 'user_data.age',
			'type'  => '>=',
			'value' => '50'
		] );

		$mailflow_woman_plus_50->conditions()->create( [
			'key'   => 'user_data.gender',
			'type'  => '=',
			'value' => 'female'
		] );

		// For Everyone +70 years of age
		$mailflow_plus_70 = \App\MailFlow::create( [
			'name'       => 'Everyone +70 of age',
			'identifier' => 'everyone-above-70',
			'should_auto_match' => 1
		] );

		$mailflow_plus_70->conditions()->create( [
			'key'   => 'user_data.age',
			'type'  => '>=',
			'value' => '70'
		] );

		// For women leaving pregnancy
		$mailflow_leaving_pregnancy = \App\MailFlow::create( [
			'name'       => 'Women leaving pregnancy',
			'identifier' => 'women-leaving-pregnancy',
			'should_auto_match' => 1
		] );

		$mailflow_leaving_pregnancy->conditions()->create( [
			'key'   => 'user_data.gender',
			'type'  => '=',
			'value' => 'female'
		] );

		$mailflow_leaving_pregnancy->conditions()->create( [
			'key'   => 'user_data.pregnancy.week',
			'type'  => '>=',
			'value' => '36' // todo set this
		] );

		// For if it's your birthday
		$mailflow_birthday = \App\MailFlow::create( [
			'name'       => 'On your birthday',
			'identifier' => 'birthday'
		] );

		$mailflow_birthday->conditions()->create( [
			'key'   => 'birthday',
			'type'  => '=',
			'value' => '1'
		] );

		// For newyears
		$mailflow_newyears = \App\MailFlow::create( [
			'name'       => 'On newsyears eve',
			'identifier' => 'happy-newyears'
		] );

		$mailflow_newyears->conditions()->create( [
			'key'   => 'newyears',
			'type'  => '=',
			'value' => '1'
		] );
	}
}
