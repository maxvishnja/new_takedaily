<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablePlansPausedToSnoozed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('subscription_paused_at');
			$table->timestamp('subscription_snoozed_until')->nullable()->after('subscription_cancelled_at');
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
			$table->dropColumn('subscription_snoozed_until');
			$table->timestamp('subscription_paused_at')->nullable()->after('subscription_cancelled_at');
        });
    }
}
