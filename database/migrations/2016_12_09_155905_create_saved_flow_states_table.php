<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedFlowStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_flow_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 40);
            $table->json('user_data');
            $table->tinyInteger('step');
            $table->tinyInteger('sub_step');
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
        Schema::drop('saved_flow_states');
    }
}
