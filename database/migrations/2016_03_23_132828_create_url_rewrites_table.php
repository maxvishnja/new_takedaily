<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUrlRewritesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('url_rewrites', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('requested_path')->index();
			$table->string('actual_path');
			$table->smallInteger('redirect_type', false, true)->default(301);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('url_rewrites');
	}
}
