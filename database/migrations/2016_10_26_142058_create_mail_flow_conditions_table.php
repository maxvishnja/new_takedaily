<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailFlowConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_flow_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mail_flow_id', false, true)->index();
            $table->string('key', 30);
            $table->string('type', 3)->default('=');
            $table->string('value', 40);
            $table->timestamps();

            $table->foreign('mail_flow_id')
	            ->references('id')
	            ->on('mail_flows');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mail_flow_conditions');
    }
}
