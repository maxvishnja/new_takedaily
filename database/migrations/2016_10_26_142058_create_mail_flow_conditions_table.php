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
            $table->integer('mail_flow_id')->index();
            $table->string('key', 20);
            $table->string('type', 3)->default('=');
            $table->string('value', 40);
            $table->timestamps();

            $table->foreign('mail_flow_id')
	            ->references('id')
	            ->on('mail_flow');
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
