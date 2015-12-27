<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Home
		\App\Page::create([
			'url_identifier'   => 'home',
			'title'            => 'Opret et abonnent på vitaminer',
			'sub_title'        => '',
			'body'             => '',
			'meta_title'       => 'Opret et abonnent på vitaminer',
			'meta_description' => 'Opret et abonnent på vitaminer hos TakeDaily',
			'meta_image'       => ''
		]);

		// About
		\App\Page::create([
			'url_identifier'   => 'about',
			'title'            => 'Om TakeDaily',
			'sub_title'        => 'Information og hjælp',
			'body'             => '###Information',
			'meta_title'       => 'Om TakeDaily',
			'meta_description' => 'Om TakeDaily og vores firma',
			'meta_image'       => ''
		]);

		// Terms
		\App\Page::create([
			'url_identifier'   => 'terms',
			'title'            => 'Vores betingelser',
			'sub_title'        => 'Retningslinjer',
			'body'             => '###1.1 Returpolitik',
			'meta_title'       => 'Vores betingelser',
			'meta_description' => 'Handelsbetingelser',
			'meta_image'       => ''
		]);

		// Terms
		\App\Page::create([
			'url_identifier'   => 'terms',
			'title'            => 'Vores betingelser',
			'sub_title'        => 'Retningslinjer',
			'body'             => '###1.1 Returpolitik',
			'meta_title'       => 'Vores betingelser',
			'meta_description' => 'Handelsbetingelser',
			'meta_image'       => ''
		]);

		// Contact
		\App\Page::create([
			'url_identifier'   => 'contact',
			'title'            => 'Kontakt os',
			'sub_title'        => 'Få hjælp og svar',
			'body'             => '###Kontaktinformationer',
			'meta_title'       => 'Kontakt os',
			'meta_description' => 'Hjælp',
			'meta_image'       => ''
		]);
	}
}
