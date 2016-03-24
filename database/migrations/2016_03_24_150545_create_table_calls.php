<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableCalls extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('calls', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('phone');
			$table->string('period');
			$table->enum('status', [ 'requested', 'done' ]);
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
		Schema::drop('calls');
	}
}
