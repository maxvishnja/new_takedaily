<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdatePlansTablePaymentMethod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('payment_method', 30)->after('id');
            $table->string('payment_customer_token')->after('id');
            $table->dropColumn('stripe_token');
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
            $table->string('stripe_token');
			$table->dropColumn('payment_method');
			$table->dropColumn('payment_customer_token');
        });
    }
}
