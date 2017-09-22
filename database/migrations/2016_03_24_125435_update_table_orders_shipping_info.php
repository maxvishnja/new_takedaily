<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTableOrdersShippingInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_name')->after('state');
            $table->string('shipping_street')->after('state');
            $table->string('shipping_city')->after('state');
            $table->string('shipping_country')->after('state');
            $table->string('shipping_zipcode')->after('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
			$table->dropColumn('shipping_name');
			$table->dropColumn('shipping_street');
			$table->dropColumn('shipping_city');
			$table->dropColumn('shipping_country');
			$table->dropColumn('shipping_zipcode');
        });
    }
}
