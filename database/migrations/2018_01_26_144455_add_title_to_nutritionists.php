<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleToNutritionists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('nutritionists') and !Schema::hasColumn('nutritionists','title')) {
            Schema::table('nutritionists', function (Blueprint $table) {
                $table->string('title')->after('last_name');

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
        Schema::table('nutritionists', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
}