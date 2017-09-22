<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCombinations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combinations', function (Blueprint $table) {
            $table->increments('id');
			$table->string('group_1', 2);
			$table->string('group_2', 2);
			$table->string('group_3', 2);
			$table->boolean('combination_possible')->default(1);
			$table->string('combination_result', 8);
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
        Schema::drop('combinations');
    }
}
