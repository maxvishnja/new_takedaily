<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDateSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_subscription', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('customer_id')->index()->unsigned();
            $table->timestamp('subscription_started_at')->nullable();
            $table->timestamp('subscription_cancelled_at')->nullable();
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
        Schema::drop('date_subscription');
    }
}
