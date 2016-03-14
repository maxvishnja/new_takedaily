<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id')->index()->unsigned();
			$table->string('reference', 16);
			$table->enum('state', [ 'new', 'paid', 'sent', 'completed', 'cancelled' ]);
			$table->integer('total')->default(0);
			$table->integer('sub_total')->default(0);
			$table->integer('total_shipping')->default(0);
			$table->integer('total_taxes')->default(0);
			$table->integer('sub_total_taxes')->default(0);
			$table->timestamps();
			$table->softDeletes();w
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}
}
