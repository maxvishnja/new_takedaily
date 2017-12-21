<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {



        if (Schema::hasColumn('reviews', 'locale')) {

        } else {
            Schema::table('reviews', function (Blueprint $table) {

                $table->string('locale')->after('review');
                $table->integer('active')->after('locale');

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
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('locale');
            $table->dropColumn('active');
        });
    }
}
