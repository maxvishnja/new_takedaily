<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('faq_id', false, true)->index();
	        $table->string('locale', 2);
	        $table->string('identifier', 60);
	        $table->string('question');
	        $table->text('answer');
            $table->timestamps();

            $table->foreign('faq_id')
	            ->references('id')
	            ->on('faqs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('faq_translations');
    }
}
