<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->index()->unsigned()->unique();
			$table->integer('plan_id')->index()->unsigned();
			$table->string('name', 50);
			$table->timestamp('birthday');
			$table->enum('gender', ['male', 'female']);
			$table->smallInteger('order_count')->unsigned()->default(0);
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customers');
    }
}
