<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationPlanProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_products', function (Blueprint $table) {
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_products', function (Blueprint $table) {
			$table->dropForeign('plan_products_plan_id_foreign');
			$table->dropForeign('plan_products_product_id_foreign');
        });
    }
}
