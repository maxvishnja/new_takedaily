<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateCustomersBalance extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customers', function (Blueprint $table)
		{
			$table->integer('balance', false, true)->after('order_count');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('customers', function (Blueprint $table)
		{
			$table->dropColumn('balance');
		});
	}
}
