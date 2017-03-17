<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableSnoozing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snoozing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->index()->unsigned();
            $table->string('email', 50);
            $table->timestamp('open')->nullable();
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
        Schema::drop('snoozing');
    }
}
