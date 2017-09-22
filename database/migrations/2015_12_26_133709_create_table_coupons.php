<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCoupons extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupons', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('description', 50);
			$table->string('code', 20);
			$table->tinyInteger('discount')->unsigned()->default(5);
			$table->enum('discount_type', [ 'percentage', 'amount', 'free_shipping' ])->default('percentage');
			$table->enum('applies_to', [ 'order', 'plan' ])->default('order');
			$table->integer('uses_left')->default(-1);
			$table->timestamp('valid_from')->nullable();
			$table->timestamp('valid_to')->nullable();
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
		Schema::drop('coupons');
	}
}
