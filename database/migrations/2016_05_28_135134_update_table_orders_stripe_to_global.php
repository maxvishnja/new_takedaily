<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTableOrdersStripeToGlobal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('stripe_charge_token');
			$table->string('payment_method', 30)->after('reference');
			$table->string('payment_token')->after('reference');
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
			$table->string('stripe_charge_token')->after('reference');
			$table->dropColumn('payment_method');
			$table->dropColumn('payment_token');
        });
    }
}
