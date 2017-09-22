<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
			$table->string('url_identifier', 50);
			$table->string('title', 100);
			$table->string('sub_title', 100);
			$table->text('body');
			$table->string('meta_title', 100);
			$table->string('meta_description', 200);
			$table->string('meta_image', 55);
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
        Schema::drop('pages');
    }
}
