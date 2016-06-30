<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_translations', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('page_id', false, true)->index();
	        $table->string('locale', 2)->index();
	        $table->string('title', 100);
	        $table->string('sub_title', 100);
	        $table->text('body');
	        $table->string('meta_title', 100);
	        $table->string('meta_description', 200);
	        $table->string('meta_image', 55);
            $table->timestamps();

	        $table->foreign('page_id')
		        ->references('id')
		        ->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('page_translations');
    }
}
