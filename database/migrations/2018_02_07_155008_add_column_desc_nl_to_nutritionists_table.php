<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDescNlToNutritionistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('nutritionists')  and !Schema::hasColumn('nutritionists','desc_nl')) {
            Schema::table('nutritionists', function (Blueprint $table) {
                $table->string('desc_nl')->after('desc');
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
            $table->dropColumn('desc_nl');
        });
    }
}
