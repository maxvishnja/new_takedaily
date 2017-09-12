<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('customer_id')->index()->unsigned();
            $table->text('source');
            $table->text('medium');
            $table->text('campaign');
            $table->text('clientId');
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
        Schema::drop('marketing');
    }
}
