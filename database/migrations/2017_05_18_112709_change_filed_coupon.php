<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFiledCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            DB::statement("ALTER TABLE `coupons` CHANGE `discount` `discount` FLOAT(10) UNSIGNED NOT NULL DEFAULT '0';");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            DB::statement("ALTER TABLE `coupons` CHANGE `discount` `discount` INT(10) UNSIGNED NOT NULL DEFAULT '0';");
        });
    }
}
