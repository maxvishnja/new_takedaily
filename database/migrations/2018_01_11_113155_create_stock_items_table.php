<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_items', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('number');
            $table->string('type');
            $table->string('reqQty');
            $table->string('qty');
            $table->integer('alert');
            $table->tinyInteger('status');
            $table->decimal('price');
            $table->rememberToken();
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
        Schema::drop('stock_items');
    }
}
