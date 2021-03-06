<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('nutritionists')) {

        } else {
            Schema::create('nutritionists', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email');
                $table->string('locale');
                $table->string('desc');
                $table->string('image');
                $table->integer('active')->default(0);
                $table->integer('order')->default(0);
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nutritionists');
    }
}
