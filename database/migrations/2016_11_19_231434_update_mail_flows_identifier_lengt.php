<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateMailFlowsIdentifierLengt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_flows', function (Blueprint $table) {
            $table->string('identifier', 35)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_flows', function (Blueprint $table) {
	        $table->string('identifier', 20)->change();
        });
    }
}
