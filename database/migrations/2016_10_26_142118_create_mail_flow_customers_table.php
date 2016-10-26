<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailFlowCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_flow_customers', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('mail_flow_id')->index();
	        $table->integer('customer_id')->index();
	        $table->timestamps();

	        $table->foreign('mail_flow_id')
	              ->references('id')
	              ->on('mail_flow');

	        $table->foreign('customer_id')
	              ->references('id')
	              ->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mail_flow_customers');
    }
}
