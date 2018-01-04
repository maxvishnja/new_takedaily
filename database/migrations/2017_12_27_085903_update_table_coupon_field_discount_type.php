<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableCouponFieldDiscountType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            DB::statement("ALTER TABLE `coupons` MODIFY  `discount_type` ENUM('percentage','amount','free_shipping','fixed' )");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `coupons` MODIFY  `discount_type` ENUM('percentage','amount','free_shipping')");
    }
}
