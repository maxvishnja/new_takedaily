<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateMailflowsShouldAutoMatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_flows', function (Blueprint $table) {
            $table->boolean('should_auto_match')->default(0)->after('is_active');
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
            $table->dropColumn('should_auto_match');
        });
    }
}
