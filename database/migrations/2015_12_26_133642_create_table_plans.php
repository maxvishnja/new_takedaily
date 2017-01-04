<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
			$table->string('stripe_token');
			$table->integer('price');
			$table->integer('price_shipping');
			$table->timestamp('subscription_started_at')->nullable();
			$table->timestamp('subscription_paused_at')->nullable();
			$table->timestamp('subscription_cancelled_at')->nullable();
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plans');
    }
}
