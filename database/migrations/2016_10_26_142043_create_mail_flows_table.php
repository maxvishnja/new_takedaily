<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_flows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 40);
            $table->string('identifier', 20);
            $table->boolean('is_active')->default(1);
            $table->boolean('only_once')->default(1);
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
        Schema::drop('mail_flows');
    }
}
