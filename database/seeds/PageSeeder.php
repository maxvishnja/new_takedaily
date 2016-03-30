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
			'body'             => '<strong>Not changeable.</strong>',
			'meta_title'       => 'Opret et abonnent på vitaminer',
			'meta_description' => 'Opret et abonnent på vitaminer hos TakeDaily',
			'meta_image'       => '',
			'is_locked'        => 1,
			'layout'           => 'plain'
		]);

		// About
		\App\Page::create([
			'url_identifier'   => 'about',
			'title'            => 'Om TakeDaily',
			'sub_title'        => 'Information og hjælp',
			'body'             => '<p>TakeDaily er en virksomhed, som ...</p>',
			'meta_title'       => 'Om TakeDaily',
			'meta_description' => 'Om TakeDaily og vores firma',
			'meta_image'       => '',
			'is_locked'        => 1,
			'layout'           => 'plain'
		]);

		// Terms
		\App\Page::create([
			'url_identifier'   => 'terms',
			'title'            => 'Vores betingelser',
			'sub_title'        => 'Retningslinjer',
			'body'             => '<h3>1.1 Returpolitik</h3><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam, at atque beatae dicta eligendi explicabo facere, facilis hic mollitia nostrum quasi qui quo tempore, unde velit? Mollitia ullam vero voluptas.</p>',
			'meta_title'       => 'Vores betingelser',
			'meta_description' => 'Handelsbetingelser',
			'meta_image'       => '',
			'is_locked'        => 1,
			'layout'           => 'plain'
		]);

		// Contact
		\App\Page::create([
			'url_identifier'   => 'contact',
			'title'            => 'Kontakt os',
			'sub_title'        => 'Få hjælp og svar',
			'body'             => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam atque beatae consequuntur cum cumque doloremque exercitationem expedita facilis iusto magnam neque perferendis quae quam quisquam ratione, sapiente veniam, veritatis voluptate?</p>',
			'meta_title'       => 'Kontakt os',
			'meta_description' => 'Hjælp',
			'meta_image'       => '',
			'is_locked'        => 1,
			'layout'           => 'plain'
		]);
	}
}
