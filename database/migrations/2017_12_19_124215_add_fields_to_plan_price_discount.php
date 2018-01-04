<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPlanPriceDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('price_discount')->default(0)->after('price');
            $table->integer('count_discount')->default(0)->after('price_discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('price_discount');
            $table->dropColumn('count_discount');
        });
    }
}
